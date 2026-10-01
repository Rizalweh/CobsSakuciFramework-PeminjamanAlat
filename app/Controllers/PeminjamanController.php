<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Pengembalian;


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
        $petugas = User::current();

        LogAktivitas::catat(User::current()->id, "Menyetujui pengajuan peminjaman {$peminjaman->kode_peminjaman} oleh user ID {$peminjaman->id_peminjam}");

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
        $petugas = User::current();

        LogAktivitas::catat(User::current()->id, "Menolak pengajuan peminjaman {$peminjaman->kode_peminjaman} oleh user ID {$peminjaman->id_peminjam}");

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

        LogAktivitas::catat($user->id, "Mengajukan peminjaman {$alat->nama_alat} (jumlah: {$data['jumlah_pinjam']})");

        return redirect(route('peminjam.alat.index'))
            ->with('success', 'Pengajuan berhasil dikirim, menunggu persetujuan Petugas.');
    }

    public function sedangDipinjam(Request $request)
{
    $user = User::current();

    // Alat yang sedang dipinjam
    $dipinjam = Peminjaman::where('id_peminjam', $user->id)
        ->where('status_peminjaman', 'disetujui')
        ->OrderBy('tanggal_kembali_rencana', 'asc')
        ->get();

    // Alat yang sudah diajukan kembali, menunggu Petugas
    $menunggu = Peminjaman::where('id_peminjam', $user->id)
        ->where('status_peminjaman', 'menunggu_pengembalian')
        ->OrderBy('tanggal_kembali_rencana', 'asc')
        ->get();

    return view('peminjam.dipinjam.index', compact('dipinjam', 'menunggu'));
}
public function ajukanPengembalian(Request $request, $id)
{
    $user = User::current();
    $peminjaman = Peminjaman::FindOrFail($id);

    if ((int) $peminjaman->id_peminjam !== (int) $user->id) {
        return redirect(route('peminjam.dipinjam'))->with('error', 'Peminjaman ini bukan milik kamu.');
    }

    if ($peminjaman->status_peminjaman !== 'disetujui') {
        return redirect(route('peminjam.dipinjam'))->with('error', 'Peminjaman ini tidak bisa diajukan pengembaliannya.');
    }

    $peminjaman->update(['status_peminjaman' => 'menunggu_pengembalian']);

    LogAktivitas::catat($user->id, "Mengajukan pengembalian {$peminjaman->kode_peminjaman}");

    return redirect(route('peminjam.dipinjam'))
        ->with('success', 'Pengajuan pengembalian dikirim, menunggu verifikasi Petugas.');
}

// Peminjam: riwayat semua peminjamannya (termasuk denda final)
public function riwayat(Request $request)
{
    $user = User::current();

    $data = Peminjaman::where('id_peminjam', $user->id)
        ->OrderBy('id_peminjaman', 'desc')
        ->paginate(10);

    return view('peminjam.riwayat.index', compact('data'));
}

public function riwayatSemua(Request $request)
{
    $batasLamaRiwayat= date('Y-m-d H:i:s', strtotime('-3 month'));
        $jumlahLamaRiwayat = Peminjaman::where('created_at', '<', $batasLamaRiwayat)->count();
    $data = $request->all();
    $status = $data['status'] ?? null;

    $query = Peminjaman::OrderBy('id_peminjaman', 'desc');

    if (!empty($status)) {
        $query = $query->where('status_peminjaman', $status);
    }

    $riwayat = $query->paginate(15);

    return view('petugas.peminjaman.riwayat.index', [
        'data'         => $riwayat,
        'statusFilter' => $status,
        'jumlahLamaRiwayat' => $jumlahLamaRiwayat,
    ]);
}
public function hapusRiwayatLama(Request $request)
{
    $batasLamaRiwayat = date('Y-m-d H:i:s', strtotime('-3 month'));
    $jumlahLamaRiwayat = Peminjaman::where('created_at', '<', $batasLamaRiwayat)->count();

    // 1.ambil id peminjaman
    $ids = Peminjaman::where('created_at', '<', $batasLamaRiwayat)->pluck('id_peminjaman');

    // 2.hapus id pengembalian
    Pengembalian::whereIn('id_peminjaman', $ids)->delete();

    // 3.hapus peminjamannya 
    Peminjaman::where('created_at', '<', $batasLamaRiwayat)->delete();

    return redirect(route('petugas.peminjaman.riwayat'))
        ->with('success', $jumlahLamaRiwayat . ' riwayat lama berhasil dihapus');
}

}