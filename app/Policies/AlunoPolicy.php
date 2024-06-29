<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserRole;

class AlunoPolicy
{
    use HandlesAuthorization;

    public function delete(User $user): bool
    {
        return $user->role == UserRole::Secretaria->value;
    }
}
