<?php

namespace App\Controllers\Core;

use App\Models\Role;
use App\Models\User;
use Sakuci\Controller;
use Sakuci\Http\Request;
use Sakuci\Session;
use App\Models\LogAktivitas;
use App\Models\Profil;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('core.auth.login');
    }

    public function showRegister()
    {
        $roles = Role::where('can_register', 1)->orderBy('name')->get();

        if ($roles === []) {
            return redirect('/login')->with('error', 'Pendaftaran belum dibuka.');
        }

        return view('core.auth.register', ['roles' => $roles]);
    }

    public function register(Request $request)
    {
        $allowed = Role::where('can_register', 1)->pluck('name');

        if ($allowed === []) {
            return redirect('/login')->with('error', 'Pendaftaran belum dibuka.');
        }

        $data = $request->validate([
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:' . implode(',', $allowed),
        ]);
        
        $user = User::create([
    'username' => $data['username'],
    'password' => password_hash($data['password'], PASSWORD_DEFAULT),
    'role'     => $data['role'],
]);

if ($data['role'] === 'peminjam') {
    $profil = $request->validate([
        'nama_lengkap' => 'required|min:3|max:100',
        'no_hp'        => 'required|numeric',
        'alamat'       => 'nullable|max:255',
        'nis'          => 'required|numeric|unique:profil,nis',
    ]);

    Profil::create([
        'id_user'      => $user->id,
        'nama_lengkap' => $profil['nama_lengkap'],
        'no_hp'        => $profil['no_hp'],
        'alamat'       => $profil['alamat'],
        'nis'          => $profil['nis']
    ]);
}

Session::put('user_id', $user->id);

        return redirect('/dashboard')->with('success', 'Pendaftaran berhasil. Selamat datang, ' . $user->username . '.');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::firstWhere('username', $data['username']);

        if (! $user || ! password_verify($data['password'], $user->password)) {
            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->withInput();
        }

        Session::put('user_id', $user->id);

        LogAktivitas::catat($user->id, 'Login');

        return redirect($user->role === 'admin' ? '/admin' : '/dashboard')
            ->with('success', 'Selamat datang, ' . $user->username . '.');
    }

    public function logout()
    {
        $user = User::current();
         if ($user) {
            LogAktivitas::catat($user->id, "Logout ({$user->username})");
        }

        Session::forget('user_id');

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
    
}

