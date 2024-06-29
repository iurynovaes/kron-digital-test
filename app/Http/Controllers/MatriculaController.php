<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\AlunoTurma;
use App\Models\Serie;
use App\Models\Turma;
use Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;

class MatriculaController extends Controller
{
    public function index()
    {
        if (! Gate::allows('view-secretaria')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $series = Serie::pluck('nome', 'id')->toArray();

        return view('matriculas.create', compact('series'));
    }

    public function matricularAluno(Request $request)
    {
        if (! Gate::allows('view-secretaria')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        try {

            $request->validate([
                'aluno_id' => 'required|exists:alunos,id',
                'turma_id' => 'required|exists:turmas,id'
            ]);
    
            $alunoId = $request->input('aluno_id');
            $turmaId = $request->input('turma_id');
    
            $aluno = Aluno::find($alunoId);
    
            if (!$aluno) {
                throw new Exception('Aluno não encontrado.');
            }
    
            $turma = Turma::find($turmaId);
    
            if (!$turma) {
                throw new Exception('Turma não encontrada.');
            }

            if ($turma->vagas <= $turma->alunos()->count()) {
                throw new Exception('Não há mais vaga disponível para esta turma.', 20);
            }
    
            // Matrícula
    
            AlunoTurma::create([
                'aluno_id' => $aluno->id,
                'turma_id' => $turma->id,
            ]);
    
            return response()->json(['success' => true, 'message' => 'Aluno matriculado com sucesso!']);

        } catch (UniqueConstraintViolationException $e) {
            return response()->json(['success' => false, 'message' => 'Aluno já está matriculado nesta turma.']);
        } catch (Throwable $th) {
            if ($th->getCode() == 20) {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            return response()->json(['success' => false, 'message' => 'Não foi possível efetuar a matrícula do aluno.']);
        }
        
        
    }

    public function removerMatricula(Request $request)
    {
        if (! Gate::allows('view-secretaria')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }
        
        try {

            $request->validate([
                'aluno_id' => 'required|exists:alunos,id',
                'turma_id' => 'required|exists:turmas,id'
            ]);
    
            $alunoId = $request->input('aluno_id');
            $turmaId = $request->input('turma_id');
    
            $aluno = Aluno::find($alunoId);
    
            if (!$aluno) {
                throw new Exception('Aluno não encontrado.');
            }
    
            $turma = Turma::find($turmaId);
    
            if (!$turma) {
                throw new Exception('Turma não encontrada.');
            }
    
            // Removendo Matrícula
    
            AlunoTurma::where([
                'aluno_id' => $aluno->id,
                'turma_id' => $turma->id,
            ])->delete();
    
            return response()->json(['success' => true, 'message' => 'Aluno foi removido da turma com sucesso!']);

        } catch (Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Não foi possível remover a matrícula do aluno.']);
        }
        
        
    }
}
