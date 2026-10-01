<?php

namespace App\Models;

use Sakuci\Database\Model;

class Pengembalian extends Model
{
    protected static ?string $table = 'pengembalian';
    protected string $primaryKey = 'id_pengembalian';

   protected array $fillable = [
    'id_peminjaman', 'id_petugas', 'tanggal_kembali_aktual',
    'kondisi_alat', 'hari_telat', 'denda_telat', 'denda_kerusakan', 'denda',
    'status_denda', 'tanggal_bayar', 'id_penerima_bayar', 'catatan',
];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id');
    }
}