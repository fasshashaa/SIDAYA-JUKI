<?php

namespace App\Http\Controllers;

use App\Models\Uep;
use App\Models\Kube;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\ProdukUmkm;
use App\Http\Requests\StoreProdukRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProdukUmkmController extends Controller
{
    /**
     * === KONFIGURASI HARDENING FILE UPLOAD (Kontrol A.8.24) ===
     * Whitelist MIME type -> ekstensi yang diizinkan. HANYA ini yang boleh disimpan.
     * MIME dideteksi dari ISI file (fileinfo), bukan dari nama/ekstensi yang dikirim client.
     */
    private const ALLOWED_MIME_TO_EXT = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
    ];

    private const MAX_FILE_SIZE_BYTES = 2 * 1024 * 1024; // 2MB, selaras dengan rule validator
    private const MAX_DIMENSION_PX    = 4000;             // cegah "decompression bomb"
    private const UPLOAD_DIR          = 'produk';         // satu folder konsisten untuk semua foto produk

    /**
     * Menampilkan daftar Usaha Ekonomi Produktif (UEP).
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');
        $page   = (int) $request->input('page', 1);

        $baseQuery = function () {
            $q = ProdukUmkm::query();

            if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
                $q->where(function ($qq) {
                    $qq->whereHas('uep', function ($q2) {
                            $q2->where('user_id', auth()->id());
                        })
                        ->orWhereHas('kube', function ($q2) {
                            $q2->where('user_id', auth()->id());
                        });
                });
            }

            return $q;
        };

        $query = $baseQuery()->with(['uep', 'kube']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($status !== '' && $status !== 'semua') {
            $query->where('status_publikasi', $status);
        }

        $produk = $query->orderByDesc('id')
            ->paginate(12, ['*'], 'page', $page)
            ->withQueryString();

        $allData        = $baseQuery()->get();
        $totalProduk    = $allData->count();
        $totalTampil    = $allData->where('status_publikasi', 'Ditampilkan')->count();
        $totalDraft     = $allData->where('status_publikasi', 'Draft')->count();
        $totalStokHabis = $allData->where('stok', 0)->count();

        if ($request->ajax() || $request->wantsJson()) {
            $items = collect($produk->items())->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'nama_produk'      => $item->nama_produk,
                    'kategori'         => $item->kategori,
                    'harga_jual'       => $item->harga_jual,
                    'stok'             => $item->stok,
                    'status_publikasi' => $item->status_publikasi,
                    'foto_url'         => $item->foto_url,
                    'uep_id'           => $item->uep_id,
                    'kube_id'          => $item->kube_id,
                    'uep_nama'         => $item->uep->nama_usaha ?? null,
                    'kube_nama'        => $item->kube->nama_kelompok_kube ?? null,
                ];
            });

            return response()->json([
                'data'         => $items,
                'current_page' => $produk->currentPage(),
                'last_page'    => $produk->lastPage(),
                'total'        => $produk->total(),
                'from'         => $produk->firstItem(),
                'to'           => $produk->lastItem(),
            ]);
        }

        return view('produk.index', compact('produk', 'totalProduk', 'totalTampil', 'totalDraft', 'totalStokHabis'));
    }

    /**
     * Simpan produk baru.
     *
     * CATATAN PERBAIKAN:
     * - Versi sebelumnya punya `return` di awal method sehingga blok validasi
     *   kepemilikan (uep/kube) & pengecekan status_verifikasi TIDAK PERNAH DIJALANKAN.
     *   Ini bug otorisasi serius: user biasa bisa membuat produk atas nama usaha siapa pun.
     *   Sekarang hanya ada SATU alur, dan otorisasi kepemilikan wajib lolos dulu.
     */
    public function store(StoreProdukRequest $request)
    {
        // Validasi (termasuk seluruh hardening foto_produk: mimes, mimetypes,
        // ukuran, dimensi) sudah dijalankan otomatis oleh StoreProdukRequest
        // sebelum method ini dipanggil. Di sini kita cukup pakai hasilnya.
        $validated = $request->validated();

        // Format pemilik_id ("uep_<id>" / "kube_<id>") sudah dipastikan valid
        // oleh rule regex di StoreProdukRequest, jadi explode() di sini aman.
        [$jenis, $id] = explode('_', $validated['pemilik_id'], 2);

        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $usaha = $jenis === 'uep'
                ? Uep::where('id', $id)->where('user_id', auth()->id())->first()
                : Kube::where('id', $id)->where('user_id', auth()->id())->first();

            abort_if(!$usaha, 403, 'Usaha tidak ditemukan atau bukan milik Anda.');
            abort_if($usaha->status_verifikasi !== 'disetujui', 422, 'Usaha ini belum disetujui, produk belum bisa disimpan.');
        }

        $data = collect($validated)->except(['pemilik_id', 'foto_produk'])->toArray();

        if ($jenis === 'uep') {
            $data['uep_id']  = $id;
            $data['kube_id'] = null;
        } else {
            $data['kube_id'] = $id;
            $data['uep_id']  = null;
        }

        if ($request->hasFile('foto_produk')) {
            $data['foto_produk'] = $this->secureStoreImage($request->file('foto_produk'));
        }

        $produk = ProdukUmkm::create($data);

        Activity::create([
            'user_id'     => auth()->id(),
            'causer_name' => auth()->user()->name,
            'description' => 'Menambahkan data Produk UMKM baru: ' . $data['nama_produk'],
        ]);

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function create()
    {
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $ueps    = Uep::all();
            $kubes   = Kube::all();
            $myUeps  = collect();
            $myKubes = collect();
        } else {
            $ueps  = collect();
            $kubes = collect();
            $myUeps  = Uep::where('user_id', auth()->id())
                            ->where('status_verifikasi', '!=', 'ditolak')
                            ->get();
            $myKubes = Kube::where('user_id', auth()->id())
                            ->where('status_verifikasi', '!=', 'ditolak')
                            ->get();
        }

        return view('produk.create', compact('ueps', 'kubes', 'myUeps', 'myKubes'));
    }

    public function edit($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        $this->authorizeOwnership($produk);

        $ueps  = Uep::all();
        $kubes = Kube::all();

        return view('produk.edit', compact('produk', 'ueps', 'kubes'));
    }

    public function update(Request $request, $id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        $this->authorizeOwnership($produk);

        // 🔒 Pre-check SEBELUM masuk ke $request->validate().
        // Laravel/Symfony membaca isi file tmp lewat finfo untuk mendeteksi
        // MIME type di rule 'mimes'/'image'. Kalau file tmp itu sudah hilang
        // atau tidak bisa dibaca di tengah proses (mis. dikarantina antivirus
        // Windows karena isinya terdeteksi mencurigakan, atau disk penuh),
        // finfo akan melempar ErrorException MENTAH yang tidak tertangkap
        // validator -> muncul sebagai crash 500 (bocor stack trace & cookie
        // kalau APP_DEBUG=true). Cek dulu manual di sini supaya kalau itu
        // terjadi, yang muncul cuma pesan error validasi yang rapi.
        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            if (!$file->isValid() || !is_readable($file->getRealPath())) {
                return back()
                    ->withErrors(['foto_produk' => 'File gagal diproses saat diunggah. Kemungkinan diblokir oleh antivirus/perangkat keamanan, atau file rusak saat proses upload. Silakan coba unggah ulang.'])
                    ->withInput();
            }
        }

        $validated = $request->validate([
            'pemilik_id'       => 'required|string',
            'nama_produk'      => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'harga_jual'       => 'required|numeric|min:0',
            'stok'             => 'required|integer|min:0',
            'deskripsi_produk' => 'nullable|string',
            'whatsapp_sales'   => 'nullable|string|max:20',
            'status_publikasi' => 'required|in:Ditampilkan,Draft',
            'foto_produk'      => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        [$jenis, $pemilikId] = array_pad(explode('_', $validated['pemilik_id'], 2), 2, null);
        if (!in_array($jenis, ['uep', 'kube'], true) || !$pemilikId) {
            throw ValidationException::withMessages([
                'pemilik_id' => 'Format pemilik_id tidak valid.',
            ]);
        }

        $data = collect($validated)->except(['pemilik_id', 'foto_produk'])->toArray();

        if ($jenis === 'uep') {
            $data['uep_id']  = $pemilikId;
            $data['kube_id'] = null;
        } else {
            $data['kube_id'] = $pemilikId;
            $data['uep_id']  = null;
        }

        if ($request->hasFile('foto_produk')) {
            $newPath = $this->secureStoreImage($request->file('foto_produk'));

            // Hapus file lama HANYA setelah file baru berhasil disimpan dengan aman
            if ($produk->foto_produk) {
                Storage::disk('public')->delete($produk->foto_produk);
            }

            $data['foto_produk'] = $newPath;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = ProdukUmkm::findOrFail($id);
        $this->authorizeOwnership($produk);

        if ($produk->foto_produk) {
            Storage::disk('public')->delete($produk->foto_produk);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
    {
        $produk = ProdukUmkm::with(['uep', 'kube'])->findOrFail($id);
        $this->authorizeOwnership($produk);

        return view('produk.show', compact('produk'));
    }

    /**
     * Pastikan produk ini memang milik user yang login (untuk role 'user').
     * Admin & super_admin selalu boleh akses semua produk.
     */
    private function authorizeOwnership(ProdukUmkm $produk): void
    {
        if (in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            return;
        }

        $isOwner = ($produk->uep && $produk->uep->user_id === auth()->id())
            || ($produk->kube && $produk->kube->user_id === auth()->id());

        abort_unless($isOwner, 403, 'Anda tidak memiliki akses ke produk ini.');
    }

    /**
     * === HARDENED FILE UPLOAD HANDLER (Kontrol A.8.24) ===
     *
     * Lapisan pertahanan yang diterapkan:
     * 1. Batas ukuran fisik file (defense-in-depth di luar rule validator).
     * 2. Deteksi MIME type dari ISI file (fileinfo), bukan dari ekstensi/nama
     *    yang dikirim client -> mencegah spoofing ekstensi (mis. shell.php.jpg).
     * 3. Verifikasi struktur gambar sesungguhnya via getimagesize() + batas dimensi
     *    -> menolak file bukan-gambar & mencegah "decompression bomb".
     * 4. RE-ENCODE gambar dari nol memakai GD -> membuang payload/metadata yang
     *    mungkin disisipkan (teknik polyglot, EXIF berbahaya, dsb). Ini adalah
     *    lapisan paling penting: walau header file lolos, byte hasil akhir yang
     *    disimpan adalah gambar bersih hasil render ulang, bukan file asli.
     * 5. Nama file baru 100% acak, ekstensi ditentukan dari MIME asli (bukan dari
     *    nama file asli) -> mencegah path traversal & ekstensi ganda.
     * 6. Disimpan ke satu folder tetap (produk) di disk "public".
     *
     * Rekomendasi tambahan di level server (tidak bisa diatur dari controller):
     * - Pastikan folder storage/app/public/produk TIDAK BISA mengeksekusi PHP.
     *   Apache (.htaccess di folder tsb.):
     *       <FilesMatch "\.(php|phtml|php\d?|phar)$">
     *           Require all denied
     *       </FilesMatch>
     *   Nginx:
     *       location ~* /storage/produk/.*\.(php|phtml)$ { deny all; }
     */
    private function secureStoreImage(UploadedFile $file): string
    {
        if ($file->getSize() === false || $file->getSize() > self::MAX_FILE_SIZE_BYTES) {
            throw ValidationException::withMessages([
                'foto_produk' => 'Ukuran file melebihi batas yang diizinkan (maks 2MB).',
            ]);
        }

        // MIME dideteksi dari isi file (fileinfo), tahan terhadap ekstensi palsu.
        $realMime = $file->getMimeType();
        if (!array_key_exists($realMime, self::ALLOWED_MIME_TO_EXT)) {
            throw ValidationException::withMessages([
                'foto_produk' => 'Tipe file tidak diizinkan. Hanya JPG dan PNG yang diperbolehkan.',
            ]);
        }

        $imageInfo = @getimagesize($file->getRealPath());
        if ($imageInfo === false) {
            throw ValidationException::withMessages([
                'foto_produk' => 'File yang diunggah bukan gambar yang valid.',
            ]);
        }

        [$width, $height] = $imageInfo;
        if ($width > self::MAX_DIMENSION_PX || $height > self::MAX_DIMENSION_PX) {
            throw ValidationException::withMessages([
                'foto_produk' => 'Dimensi gambar terlalu besar (maks ' . self::MAX_DIMENSION_PX . 'px).',
            ]);
        }

        // Render ulang gambar dari nol untuk membuang payload tersembunyi.
        $cleanImage = match ($realMime) {
            'image/jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'image/png'  => @imagecreatefrompng($file->getRealPath()),
            default      => false,
        };

        if ($cleanImage === false) {
            throw ValidationException::withMessages([
                'foto_produk' => 'Gagal memproses gambar. Pastikan file tidak rusak.',
            ]);
        }

        $extension    = self::ALLOWED_MIME_TO_EXT[$realMime];
        $filename     = Str::random(40) . '.' . $extension;
        $relativePath = self::UPLOAD_DIR . '/' . $filename;

        if (!Storage::disk('public')->exists(self::UPLOAD_DIR)) {
            Storage::disk('public')->makeDirectory(self::UPLOAD_DIR);
        }

        $absolutePath = Storage::disk('public')->path($relativePath);

        $saved = $realMime === 'image/jpeg'
            ? imagejpeg($cleanImage, $absolutePath, 85)
            : imagepng($cleanImage, $absolutePath);

        imagedestroy($cleanImage);

        if (!$saved) {
            abort(500, 'Gagal menyimpan gambar.');
        }

        return $relativePath;
    }
}