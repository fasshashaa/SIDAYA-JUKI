<?php

namespace App\Http\Controllers;

use App\Models\Kube; 
use App\Models\PenerimaManfaat; 
use App\Models\AuditLog; // Ditambahkan untuk pelaporan evidence ISO 27001
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\KubeExport;
use App\Imports\KubeImport;
 use App\Exports\KubeTemplateExport;

class KubeController extends Controller
{
    /**
     * Menampilkan daftar Kelompok KUBE Binaan Dinsos Cilacap dengan Proteksi Data Masking.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');
        $page   = (int) $request->input('page', 1);

        // 🟢 GANTI: Pastikan menggunakan Eloquent query builder utuh agar fungsi perlindungan aktif
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

        // 🔒 PENGAMANAN DATA FINANSIAL/SENSITIF ON-THE-FLY UNTUK NON-SUPERADMIN
        if (auth()->check() && auth()->user()->role !== 'super_admin') {
            $kubes->getCollection()->transform(function ($item) {
                // Contoh Penyamaran Nomor Telepon Kelompok KUBE jika bersifat rahasia
                if (!empty($item->no_telp_kube)) {
                    $item->no_telp_kube = substr($item->no_telp_kube, 0, 4) . '****' . substr($item->no_telp_kube, -4);
                }
                // Jika di tabel Kube terdapat fields seperti nomor rekening bank kelompok:
                if (!empty($item->no_rekening_kube)) {
                    $item->no_rekening_kube = substr($item->no_rekening_kube, 0, 3) . '******' . substr($item->no_rekening_kube, -3);
                }
                return $item;
            });
        }

        // Statistik dihitung menggunakan struktur model Eloquent
        $kubeStats = [
            'total_anggota' => (int) \App\Models\Kube::sum('jumlah_anggota'),
            'disetujui'     => \App\Models\Kube::where('status_verifikasi', 'disetujui')->count(),
            'pending'       => \App\Models\Kube::where('status_verifikasi', 'pending')->count(),
        ];

        // Balasan JSON untuk komponen auto-search AJAX dengan payload ter-masking
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($kubes);
        }

        return view('kube.index', compact('kubes', 'kubeStats'));
    }
   


public function downloadTemplate()
{
    return Excel::download(new KubeTemplateExport, 'Template_Import_KUBE.xlsx');
}

    public function create()
    {
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            $pms = \App\Models\PenerimaManfaat::whereNull('kube_id')->get();
            $myProfile = null;
        } else {
            $pms = collect(); 
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

            if (auth()->user()->role === 'user') {
                \App\Models\PenerimaManfaat::where('id', $validated['ketua_penerima_manfaat_id'])
                    ->update(['kube_id' => $kube->id]);
            }

            \App\Models\Activity::create([
                'user_id'     => auth()->id(),
                'causer_name' => auth()->user()->name,
                'description' => 'Menambahkan data KUBE baru: ' . $validated['nama_kelompok_kube'],
            ]);

            if (auth()->user()->role === 'user') {
                return redirect()->route('kube.status')
                    ->with('success', 'Pengajuan KUBE berhasil dikirim! Mohon tunggu proses verifikasi dari admin.');
            }

            return redirect()->route('kube.index')->with('success', 'Kelompok KUBE berhasil didaftarkan!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $kube = \App\Models\Kube::findOrFail($id);
        $pms = \App\Models\PenerimaManfaat::all();
        return view('kube.edit', compact('kube', 'pms'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kelompok_kube'    => 'required|string|max:255',
            'kecamatan_kube'        => 'required|string', 
            'desa_kube'             => 'required|string', 
            'jenis_usaha_kube'      => 'required|string',
            'no_telp_kube'          => 'required|string|max:20',
            'alamat_lengkap_kube'   => 'required|string',
            'tahun_realisasi'       => 'nullable|digits:4',
            'sumber_anggaran'       => 'nullable|string',
            'status_verifikasi'     => 'required|in:pending,disetujui,ditolak',
            'jumlah_anggota'        => 'required|numeric',
            'catatan_penolakan'     => 'nullable|string|required_if:status_verifikasi,ditolak',
        ]);

        $kube = Kube::findOrFail($id);
        $kube->update($validated);

        return redirect()->route('kube.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kube = Kube::findOrFail($id);

        \App\Models\PenerimaManfaat::where('kube_id', $kube->id)
            ->update(['kube_id' => null]);

        $kube->delete();

        return redirect()->route('kube.index')->with('success', 'Kelompok KUBE berhasil dihapus!');
    }

    public function getDesa($kecamatan)
    {
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
        $kube = \App\Models\Kube::with('ketua')->findOrFail($id);
        return view('kube.show', compact('kube'));
    }

    public function exportExcel()
    {
        return Excel::download(new KubeExport, 'data-kube.xlsx');
    }

    public function exportPdf()
    {
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

    /**
     * 🟢 ISO 27001 - Kontrol A.8.15 Audit Logging 
     * Ekspor Dokumen Evidence Log Khusus Perubahan Struktur Kelompok KUBE
     */
    public function exportAuditLogPdf()
    {
        $logs = \App\Models\AuditLog::with('user')
            ->where('model_type', \App\Models\Kube::class)
            ->orderByDesc('id')
            ->take(100)
            ->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kube.audit_pdf', compact('logs'))
            ->setPaper('a4', 'landscape'); 

        return $pdf->stream('LAPORAN_EVIDENCE_LOG_KUBE_' . date('Y-m-d_H-i-s') . '.pdf')
                   ->withHeaders([
                       'X-Frame-Options' => 'SAMEORIGIN',
                       'Content-Security-Policy' => "frame-ancestors 'self'"
                   ]);
    }
}