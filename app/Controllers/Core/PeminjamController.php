<?php

namespace App\Controllers\Core;

use App\Models\Profil;
use App\Models\User;
use Sakuci\Controller;
use Sakuci\Http\Request;

class PeminjamController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'peminjam')->orderBy('username')->paginate(10);
        return view('core.admin.peminjam.index', compact('data'));
    }

    public function create()
    {
        return view('core.admin.peminjam.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username'     => 'required|min:3|max:50|alpha_dash|unique:users,username',
            'password'     => 'required|min:6',
            'nama_lengkap' => 'required|min:3|max:100',
            'no_hp'        => 'required|numeric',
            'alamat'       => 'nullable|max:255',
        ]);

        $user = User::create([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => 'peminjam',
        ]);

        Profil::create([
            'id_user'      => $user->id,
            'nama_lengkap' => $data['nama_lengkap'],
            'no_hp'        => $data['no_hp'],
            'alamat'       => $data['alamat'],
        ]);

        return redirect(route('admin.peminjam.index'))->with('success', 'Peminjam berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('core.admin.peminjam.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username'     => 'required|min:3|max:50|alpha_dash|unique:users,username,' . $user->id . ',id',
            'password'     => 'nullable|min:6',
            'nama_lengkap' => 'required|min:3|max:100',
            'nis'          => 'required|numeric',
            'no_hp'        => 'required|numeric',
            'alamat'       => 'nullable|max:255',
        ]);

        $user->username = $data['username'];
        if (!empty($data['password'])) {
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $user->save();

        $user->profil()->update([
            'id_user'      => $user->id,
            'nama_lengkap' => $data['nama_lengkap'],
            'nis'          => $data['nis'],
            'no_hp'        => $data['no_hp'],
            'alamat'       => $data['alamat'],
        ]);

        return redirect(route('admin.peminjam.index'))->with('success', 'Data peminjam diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Peminjam dihapus.');
    }
}