<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserRole;

class TurmaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::Assistente->value, UserRole::Secretaria->value]);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::Assistente->value, UserRole::Secretaria->value]);
    }

    public function update(User $user): bool
    {
        return in_array($user->role, [UserRole::Assistente->value, UserRole::Secretaria->value]);
    }

    public function delete(User $user): bool
    {
        return in_array($user->role, [UserRole::Assistente->value, UserRole::Secretaria->value]);
    }
}
