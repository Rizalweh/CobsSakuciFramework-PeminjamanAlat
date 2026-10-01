<?php

namespace App\Models;

use Sakuci\Database\Model;

class Profil extends Model
{
    protected static ?string $table = 'profil';
    protected string $primaryKey = 'id_profil';

    protected array $fillable = ['id_user', 'nama_lengkap','nis', 'no_hp', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}