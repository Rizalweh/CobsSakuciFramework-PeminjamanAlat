<?php

namespace App\Models;

use Sakuci\Database\Model;

class Alat extends Model
{
    protected static ?string $table = 'alat';
    protected string $primaryKey = 'id_alat';
    protected array $fillable = ['id_alat', 'kode_alat', 'nama_alat', 'stok','kondisi', 'foto_alat'];
}

