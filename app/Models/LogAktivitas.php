<?php

namespace App\Models;

use Sakuci\Database\Model;

class LogAktivitas extends Model
{
    protected static ?string $table = 'log_aktivitas';
    protected string $primaryKey = 'id_log';
    public bool $timestamps = false;

    protected array $fillable = ['id_user', 'aktivitas', 'waktu'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Static helper -- dipanggil dari controller lain: LogAktivitas::catat(...)
    public static function catat(?int $userId, string $aktivitas): void
    {
        static::create([
            'id_user'   => $userId,
            'aktivitas' => $aktivitas,
            'waktu'     => date('Y-m-d H:i:s'),
        ]);
    }

}