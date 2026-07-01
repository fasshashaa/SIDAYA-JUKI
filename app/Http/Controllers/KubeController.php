<?php

namespace App\Http\Controllers; 

use App\Models\Kube; // Pastikan Anda sudah memiliki Model Kube
use App\Models\PenerimaManfaat; // Pastikan Anda sudah memiliki Model Kube
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KubeController extends Controller
{
    /**
     * Menampilkan daftar Kelompok KUBE Binaan Dinsos Cilacap.
     */
  public function index()
{
    // Mengambil semua KUBE beserta data ketua dan hitungan anggotanya
    $kubes = \App\Models\Kube::with(['ketua', 'anggota'])->get();
    return view('kube.index', compact('kubes'));
}

   public function create()
{
    // Mengambil PM yang belum masuk kelompok mana pun (kube_id is null)
    $pms = \App\Models\PenerimaManfaat::whereNull('kube_id')->get();
    return view('kube.create', compact('pms'));
}
public function store(Request $request)
{
  
try {
        $kube = \App\Models\Kube::create([
            'nama_kelompok_kube'        => $request->nama_kelompok_kube,
            'ketua_penerima_manfaat_id' => $request->ketua_penerima_manfaat_id,
            'kecamatan_kube'            => $request->kecamatan, // Mengambil dari data dd() kamu
            'desa_kube'                 => $request->desa,      // Mengambil dari data dd() kamu
            'jenis_usaha_kube'          => $request->jenis_usaha_kube,
            'no_telp_kube'              => $request->no_telp_kube,
            'alamat_lengkap_kube'       => $request->alamat_lengkap_kube,
            'tahun_realisasi'           => $request->tahun_realisasi,
            'sumber_anggaran'           => $request->sumber_anggaran,
            'status_verifikasi'         => $request->status_verifikasi,
            'jumlah_anggota'            => $request->jumlah_anggota,
        ]);

        // Jika berhasil, update anggota
        if ($request->has('anggota_ids')) {
            \App\Models\PenerimaManfaat::whereIn('id', $request->anggota_ids)
                ->update(['kube_id' => $kube->id]);
        }

       return redirect()->route('kube.index')->with('success', 'Kelompok KUBE berhasil didaftarkan!');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
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
        'tahun_realisasi'       => 'required|digits:4',
        'sumber_anggaran'       => 'required|string',
        'status_verifikasi'     => 'required|in:pending,disetujui,ditolak',
        'jumlah_anggota'        => 'required|numeric',
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
}

