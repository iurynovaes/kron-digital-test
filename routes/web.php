<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\TurmaController;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login_post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // DASHBOARD

    Route::get('/', [AdminController::class, 'index'])->name('home');

    // RELATÓRIOS

    Route::get('/relatorios', [AdminController::class, 'reports'])->name('reports.index');
    Route::post('/relatorio', [AdminController::class, 'report'])->name('reports.post');

    // ALUNOS

    Route::resource('alunos', AlunoController::class);
    Route::get('/alunos-paginados', [AlunoController::class, 'alunosDatatable'])->name('alunos.datatable');
    Route::get('/get-alunos', [AlunoController::class, 'getAlunos'])->name('alunos.ajax');
    
    // TURMAS
    
    Route::resource('turmas', TurmaController::class);
    Route::get('/alunos-paginadas', [TurmaController::class, 'turmasDatatable'])->name('turmas.datatable');
    Route::get('/get-turmas', [TurmaController::class, 'getTurmas'])->name('turmas.ajax');
    
    // MATRÍCULAS

    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    Route::post('/matricular-aluno', [MatriculaController::class, 'matricularAluno'])->name('matriculas.create');
    Route::delete('/remover-matricula', [MatriculaController::class, 'removerMatricula'])->name('matriculas.delete');
});
