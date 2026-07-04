<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Uep;
use App\Models\PenerimaManfaat;
use App\Models\AuditLog; // Ditambahkan untuk pelaporan evidence ISO 27001
use App\Models\Activity;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UepExport;
use App\Imports\UepImport;
    use App\Exports\UepTemplateExport;



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
     * Menampilkan Halaman Daftar UEP dengan Proteksi Data Masking On-the-Fly
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', ''); // status_verifikasi
        $page   = (int) $request->input('page', 1);

        // 🟢 GANTI: Gunakan Eloquent Model Query agar logika keamanan data aktif
        $query = \App\Models\Uep::query();

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

        // 🔒 PENGAMANAN DATA SENSITIF ON-THE-FLY UNTUK NON-SUPERADMIN
        if (auth()->check() && auth()->user()->role !== 'super_admin') {
            $ueps->getCollection()->transform(function ($item) {
                if (!empty($item->nik)) {
                    $item->nik = substr($item->nik, 0, 4) . '**********' . substr($item->nik, -4);
                }
                if (!empty($item->no_kk)) {
                    $item->no_kk = substr($item->no_kk, 0, 4) . '**********' . substr($item->no_kk, -4);
                }
                if (!empty($item->no_wa)) {
                    $item->no_wa = substr($item->no_wa, 0, 4) . '****' . substr($item->no_wa, -4);
                }
                if (!empty($item->nama_ibu_kandung)) {
                    $item->nama_ibu_kandung = substr($item->nama_ibu_kandung, 0, 2) . str_repeat('*', strlen($item->nama_ibu_kandung) - 2);
                }
                return $item;
            });
        }

        // Statistik total dihitung menggunakan struktur model Eloquent
        $totalUsaha = \App\Models\Uep::count();
        $statusAktif = \App\Models\Uep::where('status_usaha', 'Aktif')->count();
        $statusCounts = [
            'disetujui' => \App\Models\Uep::where('status_verifikasi', 'disetujui')->count(),
            'ditolak'   => \App\Models\Uep::where('status_verifikasi', 'ditolak')->count(),
        ];

        // Balasan JSON untuk komponen auto-search AJAX dengan payload ter-masking
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($ueps);
        }

        return view('uep.index', compact('ueps', 'totalUsaha', 'statusAktif', 'statusCounts'));
    }

    public function create()
    {
        // Ambil data penerima manfaat untuk dropdown (untuk Super Admin)
        $penerimaManfaats = \App\Models\PenerimaManfaat::all();

        // Ambil data profil user yang sedang login (untuk role User)
        $myProfile = \App\Models\PenerimaManfaat::where('user_id', auth()->id())->first();

        return view('uep.create', compact('penerimaManfaats', 'myProfile'));
    }

    public function store(Request $request)
    {
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

        $validated['user_id'] = auth()->id();

        $uep = \App\Models\Uep::create($validated);

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
                   ->setPaper('a4', 'landscape');
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

    /**
     * 🟢 ISO 27001 - Kontrol A.8.15 Audit Logging 
     * Ekspor Dokumen Evidence Log Khusus Perubahan Data Kelolaan UEP
     */
    public function exportAuditLogPdf()
    {
        $logs = \App\Models\AuditLog::with('user')
            ->where('model_type', \App\Models\Uep::class)
            ->orderByDesc('id')
            ->take(100)
            ->get();
        
        $pdf = PDF::loadView('uep.audit_pdf', compact('logs'))
            ->setPaper('a4', 'landscape'); 

        return $pdf->stream('LAPORAN_EVIDENCE_LOG_UEP_' . date('Y-m-d_H-i-s') . '.pdf')
                   ->withHeaders([
                       'X-Frame-Options' => 'SAMEORIGIN',
                       'Content-Security-Policy' => "frame-ancestors 'self'"
                   ]);
    }

public function downloadTemplate()
{
    return Excel::download(new UepTemplateExport, 'Template_Import_UEP.xlsx');
}
}