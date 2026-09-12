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
        return view('alat.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_alat' => 'required|string|max:255|unique:alat,kode_alat',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto_alat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_alat')) {
            $file = $request->file('foto_alat');
            $filename = time() . '_' . $file['name'];
            move_uploaded_file($file['tmp_name'], ('public/uploads/foto_alat/' . $filename));
            $data['foto_alat'] = $filename;
        } 

        Alat::create($data);
        return redirect(route('alat.index'))->with('success', 'Data berhasil disimpan');
    }

    public function edit(Request $request, $id)
    {
        $data = Alat::FindOrFail($id);
        return view('alat.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

    
        $data = Alat::FindOrFail($id);
        $validatedData = $request->validate([
            'kode_alat' => 'required|string|max:255|unique:alat,kode_alat,' . $data->id_alat . ',id_alat',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',    
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'foto_alat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_alat')) {

           if ($data->foto_alat && file_exists('public/uploads/foto_alat/' . $data->foto_alat)) {
                unlink('public/uploads/foto_alat/' . $data->foto_alat);
            }
            
            $file = $request->file('foto_alat');
            $fileName = time() . '_' . $file['name'];
            move_uploaded_file($file['tmp_name'], ('public/uploads/foto_alat/' . $fileName));
            $validatedData['foto_alat'] = $fileName;
        } else {
            $validatedData['foto_alat'] = $data->foto_alat;
        }

        $data->update($validatedData);
        return redirect(route('alat.index'))->with('success', 'Data berhasil diubah');
    }

    public function destroy(Request $request, $id)
    {
        $data = Alat::FindOrFail($id);

        if ($data->foto_alat && file_exists('public/uploads/foto_alat/' . $data->foto_alat)) {
            unlink('public/uploads/foto_alat/' . $data->foto_alat);
        }

        $data->delete();
        return redirect(route('alat.index'))->with('success', 'Data berhasil dihapus');
    }
}