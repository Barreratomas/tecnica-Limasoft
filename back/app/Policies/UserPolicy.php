<?php

namespace App\Policies;

use App\Models\User;

/**
 * Política de autorización para el modelo User
 * Define quién puede ver, crear o actualizar usuarios (admin-only)
 */
class UserPolicy
{
    // Solo admin puede listar usuarios
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // Solo admin puede ver detalles de un usuario
    public function view(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    // Solo admin puede crear usuarios
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    // Solo admin puede actualizar usuarios
    public function update(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }
}