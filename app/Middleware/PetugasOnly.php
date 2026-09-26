<?php

namespace App\Middleware;

/** Dibuat otomatis oleh RoleController -- hanya role "petugas" yang boleh lewat. */
class PetugasOnly extends EnsureRole
{
    protected function roles(): array
    {
        return ['petugas'];
    }
}
