<?php

namespace App\Middleware;

/** Dibuat otomatis oleh RoleController -- hanya role "siswa" yang boleh lewat. */
class SiswaOnly extends EnsureRole
{
    protected function roles(): array
    {
        return ['siswa'];
    }
}
