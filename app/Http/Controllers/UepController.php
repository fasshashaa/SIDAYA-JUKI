<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Uep;

class UepController extends Controller
{
public function show($id)
    {
        // 2. Gunakan Uep (Model), bukan UepController
        $uep = Uep::findOrFail($id); 
        return view('uep.show', compact('uep'));
    }

    public function edit($id)
    {
        // 2. Perbaiki di sini juga
        $uep = Uep::findOrFail($id); 
        return view('uep.edit', compact('uep'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_lengkap' => 'required',
        'nik' => 'required|digits:16',
        // tambahkan validasi lain sesuai kebutuhan
    ]);

    $uep = Uep::findOrFail($id);
    $uep->update($request->all());

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
    public function index()
    {
        // Mengambil data dari tabel ueps (bisa diganti relasi model nanti jika sudah siap)
        $ueps = DB::table('ueps')->orderBy('created_at', 'desc')->get();

        // Mengarahkan ke file resources/views/uep/index.blade.php
        return view('uep.index', compact('ueps'));
    }

    /**
     * Menampilkan Form Tambah Data UEP
     * URL: /uep/create (Route: uep.create)
     */
    public function create()
    {
        // Mengarahkan ke file resources/views/uep/create.blade.php
        return view('uep.create');
    }

    /**
     * Menyimpan Data Baru UEP
     */
    public function store(Request $request)
    {
        $request->validate([
            'penerima_manfaat_id' => 'nullable|integer',
            'nama_usaha' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'no_operasional_wa' => 'required|string|max:20',
            'kecamatan_usaha' => 'required|string',
            'desa_kelurahan_usaha' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'kategori_produk' => 'required|string',
            'status_perkembangan' => 'required|in:rintisan,berkembang,mandiri',
            'tahun_realisasi' => 'required|digits:4',
            'sumber_anggaran' => 'required|string',
        ]);

        DB::table('ueps')->insert([
            'nama_usaha' => $request->nama_usaha,
            'penerima_manfaat_id' => $request->penerima_manfaat_id ?? null,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'no_operasional_wa' => $request->no_operasional_wa,
            'kecamatan_usaha' => $request->kecamatan_usaha,
            'desa_kelurahan_usaha' => $request->desa_kelurahan_usaha,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kategori_produk' => $request->kategori_produk,
            'status_usaha' => 'Aktif',
            'status_perkembangan' => $request->status_perkembangan,
            'tahun_realisasi' => $request->tahun_realisasi,
            'sumber_anggaran' => $request->sumber_anggaran,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('uep.index')->with('success', 'Data UEP Berhasil Disimpan!');
    }
}