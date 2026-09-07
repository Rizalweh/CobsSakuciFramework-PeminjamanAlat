<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $data = Kategori::OrderBy('id_kategori', 'desc')->paginate(5);
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
        return redirect(route('kategori.index'))->with('success', 'Data berhasil diubah');
    }

    public function create(Request $request)
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        Kategori::create($request->all());
        return redirect(route('kategori.index'))->with('success', 'Data berhasil disimpan');
    }
}
