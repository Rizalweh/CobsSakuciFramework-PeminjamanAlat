<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $data = Alat::OrderBy('id_alat', 'desc')->paginate(5);
        return view('Alat.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        Alat::create($request->all());
        return redirect(route('alat.index'))->with('success', 'Data berhasil disimpan');
    }

    public function destroy(Request $request, $id)
    {
        $data = Alat::FindOrFail($id);
        $data->delete();
        return redirect(route('alat.index'))->with('success', 'Data berhasil dihapus');
    }

    public function edit(Request $request, $id)
    {
        $data = Alat::FindOrFail($id);
        return view('alat.edit', compact('data'));
    }
}