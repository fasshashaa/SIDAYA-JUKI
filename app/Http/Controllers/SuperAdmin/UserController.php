<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id) {
    $user = User::findOrFail($id);
    return view('superadmin.users.show', compact('user'));
}
    public function index()
    {
        // Menampilkan semua user kecuali diri sendiri (Super Admin)
     $users = User::all();
        return view('superadmin.users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Peran user berhasil diubah!');
    }

    public function destroy($id)
{
    // 1. Cari user
    $user = User::findOrFail($id);

    // 2. Proteksi: Cek apakah user yang mau dihapus adalah user yang sedang login
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
    }

    // (Opsional) Proteksi tambahan jika ingin superadmin lain tidak bisa saling hapus
    // if ($user->role === 'superadmin') {
    //    return back()->with('error', 'Akun sesama Super Admin tidak dapat dihapus!');
    // }

    $user->delete();
    return back()->with('success', 'User berhasil dihapus!');
}
// app/Http/Controllers/SuperAdmin/UserController.php

public function create() {
    return view('superadmin.users.create');
}

public function store(Request $request)
{
    // 1. Validasi
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role'     => 'required'
    ]);

    // 2. Simpan User
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'role'     => $request->role,
    ]);

    // 3. Catat Log Aktivitas (Admin menambah user)
    \App\Models\Activity::create([
        'user_id'     => auth()->id(),
        'causer_name' => auth()->user()->name,
        'description' => 'Superadmin menambahkan user baru: ' . $user->name,
    ]);

    return redirect()->route('superadmin.users.index')->with('success', 'User berhasil ditambah!');
}
public function edit($id) {
    $user = User::findOrFail($id);
    return view('superadmin.users.edit', compact('user'));
}

public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'role' => 'required',
        'status' => 'required'
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'status' => $request->status
    ]);

    return redirect()->route('superadmin.users.index')->with('success', 'Data user berhasil diupdate!');
}
}