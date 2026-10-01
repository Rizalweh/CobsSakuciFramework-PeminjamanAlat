<?php

namespace App\Controllers\Core;

use App\Models\Role;
use App\Models\User;
use Sakuci\Controller;
use Sakuci\Http\Request;

/** Halaman admin untuk menambah user dan menentukan role-nya. */
class UserController extends Controller
{
    public function index()
    {
        return view('core.admin.users.index', [
           'users' => User::where('role', '!=', 'peminjam')->orderBy('username')->get(),
           'roles' => Role::where('name', '!=', 'peminjam')->orderBy('name')->get(),
            'currentUser' => User::current()->id,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,name',
        ]);

        User::create([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'],
        ]);

        return back()->with('success', 'User "' . $data['username'] . '" berhasil ditambahkan.');
    }

    public function edit(User $user)
{
    return view('core.admin.users.edit', [
        'user'  => $user,
        'roles' => Role::orderBy('name')->get(),
    ]);
}

public function update(Request $request, User $user)
{
    $data = $request->validate([
        'username' => 'required|min:3|max:50|alpha_dash',
        'password' => 'nullable|min:6',
        'role'     => 'required|exists:roles,name',
    ]);

    $existing = User::where('username', $data['username'])->first();
    if ($existing && $existing->id !== $user->id) {
        return back()->withErrors(['username' => 'Username "' . $data['username'] . '" sudah dipakai.'])->withInput();
    }

    $user->username = $data['username'];
    $user->role     = $data['role'];

    if (!empty($data['password'])) {
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    $user->save();

    return back()->with('success', 'User "' . $user->username . '" berhasil diperbarui.');

}

public function destroy(User $user)
{
    if ($user->id === User::current()->id) {
        return back()->with('error', 'Tidak bisa menghapus akun yang sedang login.');
    }

    $username = $user->username;
    $user->delete();

    return back()->with('success', 'User "' . $username . '" berhasil dihapus.');
}
}