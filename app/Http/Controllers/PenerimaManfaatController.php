<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PenerimaManfaatExport;
use App\Imports\PenerimaManfaatImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PenerimaManfaat;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Activity;
use App\Exports\PenerimaManfaatTemplateExport;

class PenerimaManfaatController extends Controller
{
    public function show($id)
    {
        $penerima = \App\Models\PenerimaManfaat::findOrFail($id);
        return view('penerima-manfaat.show', compact('penerima'));
    }

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');
        $page   = (int) $request->input('page', 1);

        $query = DB::table('penerima_manfaats');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($status !== '' && $status !== 'semua') {
            $query->where('status_verifikasi', $status);
        }

        $penerimaManfaat = $query->orderByDesc('id')
            ->paginate(10, ['*'], 'page', $page)
            ->withQueryString();

        $statusCounts = [
            'pending'   => DB::table('penerima_manfaats')->where('status_verifikasi', 'pending')->count(),
            'disetujui' => DB::table('penerima_manfaats')->where('status_verifikasi', 'disetujui')->count(),
            'ditolak'   => DB::table('penerima_manfaats')->where('status_verifikasi', 'ditolak')->count(),
        ];
        $totalOrang = DB::table('penerima_manfaats')->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data'         => $penerimaManfaat->items(),
                'current_page' => $penerimaManfaat->currentPage(),
                'last_page'    => $penerimaManfaat->lastPage(),
                'total'        => $penerimaManfaat->total(),
                'from'         => $penerimaManfaat->firstItem(),
                'to'           => $penerimaManfaat->lastItem(),
            ]);
        }

        return view('penerima-manfaat.index', compact('penerimaManfaat', 'statusCounts', 'totalOrang'));
    }

    public function create()
    {
        $users = \App\Models\User::where('role', 'user')
            ->whereDoesntHave('penerimaManfaat')
            ->get();

        return view('penerima-manfaat.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nik' => 'required|numeric|digits:16|unique:penerima_manfaats,nik',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'no_wa' => 'nullable|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat_detail' => 'required|string',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ]);

        \App\Models\PenerimaManfaat::create($validated);

        Activity::create([
            'user_id'     => auth()->id(),
            'causer_name' => auth()->user()->name,
            'description' => 'Menambahkan data Penerima Manfaat: ' . $request->nama_lengkap,
        ]);

        return redirect()->route('penerima-manfaat.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $penerima = DB::table('penerima_manfaats')->where('id', $id)->first();
        if (!$penerima) abort(404);

        $users = \App\Models\User::where('role', 'user')
            ->where(function ($q) use ($penerima) {
                $q->whereDoesntHave('penerimaManfaat')
                  ->orWhere('id', $penerima->user_id);
            })
            ->orderBy('name')
            ->get();

        return view('penerima-manfaat.edit', compact('penerima', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nik' => 'required|numeric|digits:16|unique:penerima_manfaats,nik,' . $id,
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'no_wa' => 'nullable|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat_detail' => 'required|string',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ]);

        $validated['updated_at'] = now();

        DB::table('penerima_manfaats')->where('id', $id)->update($validated);

        return redirect()->route('penerima-manfaat.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('penerima_manfaats')->where('id', $id)->delete();
        return redirect()->route('penerima-manfaat.index')->with('success', 'Data berhasil dihapus!');
    }

    public function getDesaByKecamatan($kecamatanNama)
    {
        $desas = DB::table('wilayah_desas')
                   ->where('kecamatan_nama', $kecamatanNama)
                   ->orderBy('nama_desa', 'asc')
                   ->pluck('nama_desa');

        return response()->json($desas);
    }

    public function exportPdf()
    {
        $data = \App\Models\PenerimaManfaat::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penerima-manfaat.pdf', compact('data'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-seluruh-penerima.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PenerimaManfaatExport, 'Data_Penerima_Manfaat_' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PenerimaManfaatImport, $request->file('file'));
            return back()->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new PenerimaManfaatTemplateExport, 'Template_Import_Penerima_Manfaat.xlsx');
    }

    /**
     * 🟢 ISO 27001 - Kontrol A.8.15 Audit Logging
     * Ekspor Dokumen Evidence Log Khusus Perubahan Data Penerima Manfaat
     */
    public function exportAuditLogPdf()
    {
        $logs = \App\Models\AuditLog::with('user')
            ->where('model_type', \App\Models\PenerimaManfaat::class)
            ->orderByDesc('id')
            ->take(100)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penerima-manfaat.audit_pdf', compact('logs'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('LAPORAN_EVIDENCE_LOG_PENERIMA_MANFAAT_' . date('Y-m-d_H-i-s') . '.pdf')
                   ->withHeaders([
                       'X-Frame-Options' => 'SAMEORIGIN',
                       'Content-Security-Policy' => "frame-ancestors 'self'"
                   ]);
    }
}