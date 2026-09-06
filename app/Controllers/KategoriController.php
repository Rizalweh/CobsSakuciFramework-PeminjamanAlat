<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $data = Kategori::paginate(2);
       return view('kategori.index', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = Kategori::FindOrFail($id);
        return view('kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Kategori::FindOrFail($id);
        $data->update($request->all());
        return redirect(route('admin.kategori.index'))->with('success', 'Data berhasil diubah');
    }
}
