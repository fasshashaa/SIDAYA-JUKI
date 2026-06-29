<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaManfaatController extends Controller
{
    public function index()
    {
        // Ubah nama variabel agar konsisten dengan View index.blade.php
        $penerimaManfaat = DB::table('penerima_manfaats')->paginate(10);
    return view('penerima-manfaat.index', compact('penerimaManfaat'));
    }

    public function create()
    {
        return view('penerima-manfaat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:penerima_manfaats,nik',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'no_wa' => 'nullable|string', // Ubah ke string agar bisa menyimpan format 08...
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat_detail' => 'required|string',
        ]);

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        DB::table('penerima_manfaats')->insert($validated);

        return redirect()->route('penerima-manfaat.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $penerima = DB::table('penerima_manfaats')->where('id', $id)->first();
        if (!$penerima) abort(404);

        return view('penerima-manfaat.edit', compact('penerima'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:penerima_manfaats,nik,' . $id,
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'no_wa' => 'nullable|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat_detail' => 'required|string',
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

    // Pastikan route di api.php mengarah ke sini
    public function getDesaByKecamatan($kecamatanNama)
    {
        $desas = DB::table('wilayah_desas')
                   ->where('kecamatan_nama', $kecamatanNama)
                   ->orderBy('nama_desa', 'asc')
                   ->pluck('nama_desa');

        return response()->json($desas);
    }
}