<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $batasLama = date('Y-m-d', strtotime('-3 month'));
        $jumlahLama = LogAktivitas::where('waktu', '<', $batasLama)->count();

        $data = LogAktivitas::OrderBy('waktu', 'desc')->paginate(20);
        return view('core.admin.log.index', compact('data', 'jumlahLama'));
    }

    public function hapusLama(Request $request)
{
    $batasLama = date('Y-m-d H:i:s', strtotime('-3 month'));

    $jumlahLama = LogAktivitas::where('waktu', '<', $batasLama)->count();
    LogAktivitas::where('waktu', '<', $batasLama)->delete();

    return redirect(route('admin.log.index'))
        ->with('success', $jumlahLama . ' log lama berhasil dihapus');
}

    public function destroy(Request $request, $id)
    {
        LogAktivitas::destroy($id);
        return back()->with('success', 'Aktivitas Telah Dihapus.');
    }

}