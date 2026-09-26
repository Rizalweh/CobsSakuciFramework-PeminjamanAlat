<?php

namespace App\Middleware;

/** Dibuat otomatis oleh RoleController -- hanya role "peminjam" yang boleh lewat. */
class PeminjamOnly extends EnsureRole
{
    protected function roles(): array
    {
        return ['peminjam'];
    }
}
