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
    $query = \App\Models\Kube::query();
    
    if($request->has('status')) {
        $query->where('status', $request->status);
    }
    
    $kubes = $query->get();
    // Mengambil semua KUBE beserta data ketua dan hitungan anggotanya
    $kubes = \App\Models\Kube::with(['ketua', 'anggota'])->get();
    return view('kube.index', compact('kubes'));
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

// // Menyimpan hasil perubahan
// public function update(Request $request, $id)
// {
//     $kube = \App\Models\Kube::findOrFail($id);

//     // 1. Update data utama
//     $kube->update([
//         'nama_kelompok_kube'        => $request->nama_kelompok_kube,
//         'ketua_penerima_manfaat_id' => $request->ketua_penerima_manfaat_id,
//         'kecamatan_kube'            => $request->kecamatan,
//         'desa_kube'                 => $request->desa,
//         'jenis_usaha_kube'          => $request->jenis_usaha_kube,
//         'no_telp_kube'              => $request->no_telp_kube,
//         'alamat_lengkap_kube'       => $request->alamat_lengkap_kube,
//         'tahun_realisasi'           => $request->tahun_realisasi,
//         'sumber_anggaran'           => $request->sumber_anggaran,
//         'status_verifikasi'         => $request->status_verifikasi,
//         'jumlah_anggota'            => $request->jumlah_anggota,
//     ]);

//     // 2. Update relasi anggota: reset dulu, baru set yang baru
//     \App\Models\PenerimaManfaat::where('kube_id', $kube->id)->update(['kube_id' => null]);
    
//     if ($request->has('anggota_ids')) {
//         \App\Models\PenerimaManfaat::whereIn('id', $request->anggota_ids)
//             ->update(['kube_id' => $kube->id]);
//     }

//     return redirect()->route('kube.index')->with('success', 'Data KUBE berhasil diupdate!');
// }

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

