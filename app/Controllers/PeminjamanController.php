<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;

class PeminjamanController extends Controller
{
    // Petugas: daftar pengajuan pending
    public function index(Request $request)
    {
        $data = Peminjaman::where('status_peminjaman', 'pending')
            ->OrderBy('tanggal_pengajuan', 'desc')
            ->paginate(10);

        return view('petugas.peminjaman.index', compact('data'));
    }

    // Petugas: setujui pengajuan -> stok dikurangi di sini
    public function setujui(Request $request, $id)
    {
        $peminjaman = Peminjaman::FindOrFail($id);

        if ($peminjaman->status_peminjaman !== 'pending') {
            return redirect(route('petugas.peminjaman.index'))
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $alat = Alat::FindOrFail($peminjaman->id_alat);

        if ($alat->stok < $peminjaman->jumlah_pinjam) {
            return redirect(route('petugas.peminjaman.index'))
                ->with('error', "Stok {$alat->nama_alat} tidak mencukupi.");
        }

        // Update status DULU (semacam kunci manual, karena tidak ada transaction),
        // baru kurangi stok setelahnya.
        $peminjaman->update(['status_peminjaman' => 'disetujui']);
        $alat->update(['stok' => $alat->stok - $peminjaman->jumlah_pinjam]);

        return redirect(route('petugas.peminjaman.index'))
            ->with('success', 'Peminjaman disetujui, stok diperbarui.');
    }

    // Petugas: tolak pengajuan
    public function tolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::FindOrFail($id);

        if ($peminjaman->status_peminjaman !== 'pending') {
            return redirect(route('petugas.peminjaman.index'))
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $peminjaman->update([
            'status_peminjaman' => 'ditolak',
            'catatan' => $request->input('catatan'),
        ]);

        return redirect(route('petugas.peminjaman.index'))
            ->with('success', 'Peminjaman ditolak.');
    }

     public function ajukan(Request $request)
    {
        $data = $request->all();
        $user = User::current();

        $alat = Alat::FindOrFail($data['id_alat']);

        if ($alat->stok < $data['jumlah_pinjam']) {
            return redirect(route('peminjam.alat.index'))
                ->with('error', "Stok {$alat->nama_alat} tidak mencukupi.");
        }

        Peminjaman::create([
            'kode_peminjaman'         => 'PJM-' . strtoupper(substr(md5(uniqid()), 0, 8)),
            'id_peminjam'             => $user->id,
            'id_alat'                 => $data['id_alat'],
            'jumlah_pinjam'           => $data['jumlah_pinjam'],
            'tanggal_pengajuan'       => date('Y-m-d'),
            'tanggal_pinjam'          => $data['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $data['tanggal_kembali_rencana'],
            'status_peminjaman'       => 'pending',
            'catatan'                 => $data['catatan'] ?? null,
        ]);

        return redirect(route('peminjam.alat.index'))
            ->with('success', 'Pengajuan berhasil dikirim, menunggu persetujuan Petugas.');
    }
}