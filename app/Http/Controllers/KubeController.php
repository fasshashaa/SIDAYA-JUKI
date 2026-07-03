<?php

namespace App\Http\Controllers;

use App\Models\Kube; // Pastikan Anda sudah memiliki Model Kube
use App\Models\PenerimaManfaat; // Pastikan Anda sudah memiliki Model Kube
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\KubeExport;
use App\Imports\KubeImport;

class KubeController extends Controller
{
    /**
     * Menampilkan daftar Kelompok KUBE Binaan Dinsos Cilacap.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');
        $page   = (int) $request->input('page', 1);

        $query = \App\Models\Kube::with(['ketua', 'anggota']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kelompok_kube', 'like', "%{$search}%")
                  ->orWhereHas('ketua', function ($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        if ($status !== '' && $status !== 'semua') {
            $query->where('status_verifikasi', $status);
        }

        $kubes = $query->orderByDesc('id')
            ->paginate(10, ['*'], 'page', $page)
            ->withQueryString();

        // Statistik selalu dihitung dari SELURUH data (tidak ikut kefilter pencarian)
        $kubeStats = [
            'total_anggota' => (int) \App\Models\Kube::sum('jumlah_anggota'),
            'disetujui'     => \App\Models\Kube::where('status_verifikasi', 'disetujui')->count(),
            'pending'       => \App\Models\Kube::where('status_verifikasi', 'pending')->count(),
        ];

        // Kalau dipanggil via fetch/AJAX (dari fitur auto search), balas JSON saja
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data'         => $kubes->items(),
                'current_page' => $kubes->currentPage(),
                'last_page'    => $kubes->lastPage(),
                'total'        => $kubes->total(),
                'from'         => $kubes->firstItem(),
                'to'           => $kubes->lastItem(),
            ]);
        }

        return view('kube.index', compact('kubes', 'kubeStats'));
    }

    public function create()
    {
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            // Admin/Super Admin: bebas pilih ketua dari PM yang belum punya kelompok
            $pms = \App\Models\PenerimaManfaat::whereNull('kube_id')->get();
            $myProfile = null;
        } else {
            // User biasa: otomatis jadi ketua dari profil PM miliknya sendiri
            $pms = collect(); // tidak dipakai untuk role user, tapi tetap dikirim agar view tidak error
            $myProfile = \App\Models\PenerimaManfaat::where('user_id', auth()->id())->first();
        }

        return view('kube.create', compact('pms', 'myProfile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelompok_kube'        => 'required|string|max:255',
            'ketua_penerima_manfaat_id' => 'required|integer',
            'kecamatan_kube'            => 'required|string',
            'desa_kube'                 => 'required|string',
            'jenis_usaha_kube'          => 'required|string',
            'no_telp_kube'              => 'nullable|string',
            'alamat_lengkap_kube'       => 'required|string',
            'tahun_realisasi'           => 'nullable|integer',
            'sumber_anggaran'           => 'nullable|string',
            'status_verifikasi'         => 'required|string',
            'jumlah_anggota'            => 'required|integer',

        ]);

        try {
            $validated['user_id'] = auth()->id();

            $kube = \App\Models\Kube::create($validated);

            if ($request->has('anggota_ids')) {
                \App\Models\PenerimaManfaat::whereIn('id', $request->anggota_ids)
                    ->update(['kube_id' => $kube->id]);
            }

            // Kalau yang jadi ketua adalah user sendiri (role user), tandai juga PM tsb masuk ke kelompok ini
            if (auth()->user()->role === 'user') {
                \App\Models\PenerimaManfaat::where('id', $validated['ketua_penerima_manfaat_id'])
                    ->update(['kube_id' => $kube->id]);
            }

            \App\Models\Activity::create([
                'user_id'     => auth()->id(),
                'causer_name' => auth()->user()->name,
                'description' => 'Menambahkan data KUBE baru: ' . $validated['nama_kelompok_kube'],
            ]);

            // Redirect sesuai role:
            // Admin & Super Admin -> daftar kelolaan KUBE
            // User biasa -> halaman status pengajuan pribadi
            if (auth()->user()->role === 'user') {
                return redirect()->route('kube.status')
                    ->with('success', 'Pengajuan KUBE berhasil dikirim! Mohon tunggu proses verifikasi dari admin.');
            }

            return redirect()->route('kube.index')->with('success', 'Kelompok KUBE berhasil didaftarkan!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $kube = Kube::findOrFail($id);

        // Opsional: Reset kube_id di tabel penerima_manfaat agar tidak null/error
        \App\Models\PenerimaManfaat::where('kube_id', $kube->id)
            ->update(['kube_id' => null]);

        $kube->delete();

        return redirect()->route('kube.index')->with('success', 'Kelompok KUBE berhasil dihapus!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $kube = Kube::findOrFail($id);

        $kube = \App\Models\Kube::findOrFail($id);
        // Mengambil PM yang belum punya KUBE ATAU PM yang sudah menjadi anggota KUBE ini
        $pms = \App\Models\PenerimaManfaat::all();
        return view('kube.edit', compact('kube', 'pms'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi harus sesuai dengan 'name' di HTML form kamu
        $validated = $request->validate([
            'nama_kelompok_kube'    => 'required|string|max:255',
            'kecamatan_kube'        => 'required|string', // Pastikan di HTML namanya 'kecamatan_kube'
            'desa_kube'             => 'required|string', // Pastikan di HTML namanya 'desa_kube'
            'jenis_usaha_kube'      => 'required|string',
            'no_telp_kube'          => 'required|string|max:20',
            'alamat_lengkap_kube'   => 'required|string',
            'tahun_realisasi'       => 'nullable|digits:4',
            'sumber_anggaran'       => 'nullable|string',
            'status_verifikasi'     => 'required|in:pending,disetujui,ditolak',
            'jumlah_anggota'        => 'required|numeric',
             'catatan_penolakan'  => 'nullable|string|required_if:status_verifikasi,ditolak',
        ]);

        $kube = Kube::findOrFail($id);

        // 2. Update data
        $kube->update($validated);

        return redirect()->route('kube.index')->with('success', 'Data berhasil diperbarui!');
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

    public function show($id)
    {
        // Memuat data kube beserta relasi ketuanya
        $kube = \App\Models\Kube::with('ketua')->findOrFail($id);
        return view('kube.show', compact('kube'));
    }

    public function exportExcel()
    {
        return Excel::download(new KubeExport, 'data-kube.xlsx');
    }

    public function exportPdf()
    {
        // Mengambil data dengan eager loading agar tidak terjadi N+1 query
        $data = Kube::with('ketuaPenerimaManfaat')->get();

        $pdf = \PDF::loadView('kube.pdf', compact('data'))
                   ->setPaper('a4', 'landscape');

        return $pdf->download('data-kube-'.date('Y-m-d').'.pdf');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new KubeImport, $request->file('file'));
        return back()->with('success', 'Data KUBE berhasil diimpor!');
    }

    public function myStatus()
    {
        $kubes = \App\Models\Kube::with('ketua')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('kube.status', compact('kubes'));
    }

}