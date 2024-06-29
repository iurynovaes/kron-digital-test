<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Enums\UserRole;
use App\Models\Aluno;
use App\Models\Turma;
use App\Policies\AlunoPolicy;
use App\Policies\TurmaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Aluno::class => AlunoPolicy::class,
        Turma::class => TurmaPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // ALUNO

        Gate::define('delete-aluno', function (User $user) {
            return (new AlunoPolicy)->delete($user);
        });

        // TURMA

        Gate::define('view-turma', function (User $user) {
            return (new TurmaPolicy)->viewAny($user);
        });

        Gate::define('create-turma', function (User $user) {
            return (new TurmaPolicy)->create($user);
        });

        Gate::define('update-turma', function (User $user) {
            return (new TurmaPolicy)->update($user);
        });

        Gate::define('delete-turma', function (User $user) {
            return (new TurmaPolicy)->delete($user);
        });

        // DASHBOARD

        Gate::define('view-secretaria', function (User $user) {
            return $user->role == UserRole::Secretaria->value;
        });

        // RELATÓRIO

        Gate::define('view-relatorio', function (User $user) {
            return in_array($user->role, [UserRole::Assistente->value, UserRole::Secretaria->value]);
        });
    }
}

