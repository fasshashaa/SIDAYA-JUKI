<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Uep;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PenerimaManfaat;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UepExport;
use App\Imports\UepImport;

class UepController extends Controller
{
    public function show($id)
    {
        // Mengambil data UEP beserta relasi ke penerima manfaat
        $uep = Uep::with('penerimaManfaat')->findOrFail($id);
        return view('uep.show', compact('uep'));
    }

    public function edit($id)
    {
        $uep = Uep::findOrFail($id);

        // Pastikan variabel ini ada dan berisi data dari model PenerimaManfaat
        $penerimaManfaats = \App\Models\PenerimaManfaat::all();

        return view('uep.edit', compact('uep', 'penerimaManfaats'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
             'catatan_penolakan'  => 'nullable|string|required_if:status_verifikasi,ditolak',
          'penerima_manfaat_id' => 'nullable|integer',
                'nama_usaha' => 'required|string|max:255',
                'nik' => 'required|numeric|digits:16',
                'no_kk' => 'required|numeric|digits:16',
                'nama_lengkap' => 'required|string|max:255',
                'nama_ibu_kandung' => 'required|string|max:255',
                'no_wa' => 'required|string|max:20',
                'kecamatan_usaha' => 'required|string',
                'desa_kelurahan_usaha' => 'required|string',
                'alamat_lengkap' => 'required|string',
                'kategori_produk' => 'required|string',
                'status_perkembangan' => 'required|in:rintisan,berkembang,mandiri',
                'tahun_realisasi' => 'nullable|digits:4',
                'sumber_anggaran' => 'nullable|string',
                'status_verifikasi'    => 'required|in:pending,disetujui,ditolak',
        ]);

        $uep = Uep::findOrFail($id);
        $uep = Uep::findOrFail($id);
        $uep->update($validated); // Hanya update field yang divalidasi

        return redirect()->route('uep.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $uep = Uep::findOrFail($id);
        $uep->delete();
        return redirect()->route('uep.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Menampilkan Halaman Daftar UEP
     * URL: /uep (Route: uep.index)
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', ''); // status_verifikasi
        $page   = (int) $request->input('page', 1);

        $query = DB::table('ueps');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($status !== '' && $status !== 'semua') {
            $query->where('status_verifikasi', $status);
        }

        $ueps = $query->orderByDesc('id')
            ->paginate(10, ['*'], 'page', $page)
            ->withQueryString();

        // Statistik total selalu dihitung dari SELURUH data (tidak ikut kefilter pencarian)
        $totalUsaha = DB::table('ueps')->count();
        $statusAktif = DB::table('ueps')->where('status_usaha', 'Aktif')->count();
        $statusCounts = [
            'disetujui' => DB::table('ueps')->where('status_verifikasi', 'disetujui')->count(),
            'ditolak'   => DB::table('ueps')->where('status_verifikasi', 'ditolak')->count(),
        ];

        // Kalau dipanggil via fetch/AJAX (dari fitur auto search), balas JSON saja
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data'         => $ueps->items(),
                'current_page' => $ueps->currentPage(),
                'last_page'    => $ueps->lastPage(),
                'total'        => $ueps->total(),
                'from'         => $ueps->firstItem(),
                'to'           => $ueps->lastItem(),
            ]);
        }

        return view('uep.index', compact('ueps', 'totalUsaha', 'statusAktif', 'statusCounts'));
    }

    /**
     * Menampilkan Form Tambah Data UEP
     * URL: /uep/create (Route: uep.create)
     */
    public function create()
    {
        // Ambil data penerima manfaat untuk dropdown (untuk Super Admin)
        $penerimaManfaats = \App\Models\PenerimaManfaat::all();

        // Ambil data profil user yang sedang login (untuk role User)
        $myProfile = \App\Models\PenerimaManfaat::where('user_id', auth()->id())->first();

        return view('uep.create', compact('penerimaManfaats', 'myProfile'));
    }

    /**
     * Menyimpan Data Baru UEP
     */
    public function store(Request $request)
    {
        // 1. Validasi: Hanya aturan yang ditulis di sini
        $validated = $request->validate([
            'nama_usaha'           => 'required|string|max:255',
            'penerima_manfaat_id'  => 'nullable|integer',
            'nik'                  => 'required|numeric|digits:16',
            'no_kk'                => 'required|numeric|digits:16',
            'nama_lengkap'         => 'required|string|max:255',
            'nama_ibu_kandung'     => 'required|string|max:255',
            'no_wa'                => 'nullable|string',
            'kecamatan_usaha'      => 'required|string',
            'desa_kelurahan_usaha' => 'required|string',
            'alamat_lengkap'       => 'required|string',
            'kategori_produk'      => 'required|string',
            'status_usaha'         => 'required|string',
            'status_perkembangan'  => 'required|string',
            'tahun_realisasi'      => 'nullable|integer',
            'sumber_anggaran'      => 'nullable|string',
        ]);

        // 2. Tambahkan user_id secara manual
        $validated['user_id'] = auth()->id();

        // 3. Simpan ke Database
        // Tidak perlu created_at/updated_at karena Eloquent otomatis mengisinya
        $uep = \App\Models\Uep::create($validated);

        // 4. Catat Aktivitas
        \App\Models\Activity::create([
            'user_id'     => auth()->id(),
            'causer_name' => auth()->user()->name,
            'description' => 'Menambahkan data UEP baru: ' . $validated['nama_usaha'],
        ]);
        if (auth()->user()->role === 'user') {
        return redirect()->route('uep.status')
            ->with('success', 'Pengajuan UEP berhasil dikirim! Mohon tunggu proses verifikasi dari admin.');
    }

    return redirect()->route('uep.index')->with('success', 'Data UEP Berhasil Disimpan!');
    }

    public function getDesa($kecamatan)
    {
        // Sesuaikan data ini dengan daftar desa di kecamatan Anda
        $data = [
            'Cilacap Tengah' => ['Sidanegara', 'Donan', 'Tambakreja', 'Lomanis'],
            'Cilacap Utara' => ['Kebonmanis', 'Gombolharjo', 'Karangtalun', 'Martasinga'],
            'Cilacap Selatan' => ['Tegalkamulyan', 'Tegalreja', 'Sidakaya'],
            'Adipala' => ['Adipala', 'Adireja', 'Karanganyar'],
            'Majenang' => ['Majenang', 'Jenang', 'Padangjaya'],
        ];

        return response()->json($data[$kecamatan] ?? []);
    }

    public function getDesaByKecamatan($kecamatanNama)
    {
        $desas = DB::table('wilayah_desas')
                   ->where('kecamatan_nama', $kecamatanNama)
                   ->orderBy('nama_desa', 'asc')
                   ->pluck('nama_desa');

        return response()->json($desas);
    }

    public function exportExcel()
    {
        return Excel::download(new UepExport, 'data-uep.xlsx');
    }

    public function exportPdf()
    {
        $data = Uep::all();
        $pdf = PDF::loadView('uep.pdf', compact('data'))
                   ->setPaper('a4', 'landscape'); // Mengubah ke mode landscape
        return $pdf->download('data-uep.pdf');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);

        try {
            Excel::import(new UepImport, $request->file('file'));
            return back()->with('success', 'Data UEP berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal impor: ' . $e->getMessage());
        }
    }

    public function myStatus()
    {
        $ueps = Uep::where('user_id', auth()->id())->latest()->get();

        return view('uep.status', compact('ueps'));
    }

}