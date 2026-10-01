<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\User;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $totalAlat = Alat::count();
        $tersedia = Alat::where('stok', '>', 0)->count();
        $dipinjam = $totalAlat - $tersedia;

        $stat = [
            'total' => $totalAlat,
            'tersedia' => $tersedia,
            'dipinjam' => $dipinjam,
            'kategori' => Kategori::count(),
        ];
          $kategori = Kategori::all();

          $alatTerbaru = Alat::orderBy('id_alat', 'desc')->take(5)->get();

        return view('welcome', [
            'stat' => $stat,
            'kategori' => $kategori,
            'alatTerbaru' => $alatTerbaru,
            'currentUser' => User::current(),
        ]);
    }
}
