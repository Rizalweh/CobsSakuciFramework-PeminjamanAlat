<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    // path absolut ke folder upload, dihitung sekali
    private function uploadPath(): string
    {
        return dirname(__DIR__, 2) . '/public/uploads/foto_alat/';
    }

    public function index(Request $request)
    {
        $data = Alat::OrderBy('id_alat', 'desc')->paginate(5);
        return view('alat.index', compact('data'));
    }

    public function create(Request $request)
    {
        $kategori = Kategori::all();
        return view('alat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_alat' => 'required|string|max:255|unique:alat,kode_alat',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
            'foto_alat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_alat')) {
            $file = $request->file('foto_alat');
            $filename = time() . '_' . $file['name'];

            if (!is_dir($this->uploadPath())) {
                mkdir($this->uploadPath(), 0775, true);
            }

            move_uploaded_file($file['tmp_name'], $this->uploadPath() . $filename);
            $data['foto_alat'] = $filename;
        }

        Alat::create($data);
        return redirect(route('alat.index'))->with('success', 'Data berhasil disimpan');
    }

    public function edit(Request $request, $id)
    {
        $data = Alat::FindOrFail($id);
        $kategori = Kategori::all();
        return view('alat.edit', compact('data', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $data = Alat::FindOrFail($id);
        $validatedData = $request->validate([
            'kode_alat' => 'required|string|max:255|unique:alat,kode_alat,' . $data->id_alat . ',id_alat',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
            'foto_alat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_alat')) {

            if ($data->foto_alat && file_exists($this->uploadPath() . $data->foto_alat)) {
                unlink($this->uploadPath() . $data->foto_alat);
            }

            $file = $request->file('foto_alat');
            $fileName = time() . '_' . $file['name'];

            if (!is_dir($this->uploadPath())) {
                mkdir($this->uploadPath(), 0775, true);
            }

            move_uploaded_file($file['tmp_name'], $this->uploadPath() . $fileName);
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

        if ($data->foto_alat && file_exists($this->uploadPath() . $data->foto_alat)) {
            unlink($this->uploadPath() . $data->foto_alat);
        }

        $data->delete();
        return redirect(route('alat.index'))->with('success', 'Data berhasil dihapus');
    }

    // Peminjam: hanya tampilkan alat dengan stok tersedia
public function daftarAlat(Request $request)
{
    $data = Alat::where('stok', '>', 0)->OrderBy('nama_alat', 'asc')->paginate(9);
    return view('peminjam.alat.index', compact('data'));
}
}
