<?php

namespace App\Http\Controllers;

use App\Enums\Turno;
use App\Models\Aluno;
use App\Models\Serie;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $alunos = Aluno::count();
        $turmas_manha = Turma::where('turno', '=', Turno::MANHA)->count();
        $turmas_tarde = Turma::where('turno', '=', Turno::TARDE)->count();
        $turmas_integral = Turma::where('turno', '=', Turno::INTEGRAL)->count();

        return view('home', compact('alunos', 'turmas_manha', 'turmas_tarde', 'turmas_integral'));
    }
    
    public function reports()
    {
        $reports = [
            'alunos_serie' => 'Total de alunos cadastrados por série, segmento',
            'alunos_turma' => 'Total de alunos matriculados por turma',
            'alunos_irmaos' => 'Relatório de irmãos'
        ];

        return view('reports.index', compact('reports'));
    }
    
    public function report(Request $request)
    {
        $report = trim($request->input('report'));
        $nome_pai_mae = mb_strtoupper(trim($request->input('nome_pai_mae') ?? ''));

        $blade = 'reports.' . $report;

        switch ($report) {
            case 'alunos_serie':
                $data = $this->getAlunosSerieReport();
                break;
            case 'alunos_turma':
                $data = $this->getAlunosTurmaReport();
                break;
            case 'alunos_irmaos':
                $data = $this->getAlunosIrmaosReport($nome_pai_mae);
                break;
        }

        return view($blade, compact('data', 'nome_pai_mae'));
    }

    public function getAlunosSerieReport()
    {
        $alunosSerie = Serie::join('alunos', 'alunos.serie_id', '=', 'series.id')
            ->select('series.nome as serie_nome', DB::raw('COUNT(alunos.id) as tot_alunos'))
            ->groupBy('series.nome')
            ->get();
        
        $alunosSegmento = Serie::join('alunos', 'alunos.serie_id', '=', 'series.id')
            ->select(DB::raw("CASE
                WHEN series.nome IN ('G1', 'G2', 'G3') THEN 'Infantil'
                WHEN series.nome IN ('1º ano', '2º ano', '3º ano', '4º ano', '5º ano') THEN 'Anos iniciais'
                WHEN series.nome IN ('6º ano', '7º ano', '8º ano', '9º ano') THEN 'Anos finais'
                ELSE 'Ensino Médio'
            END as segmento"), DB::raw('COUNT(alunos.id) as tot_alunos'))
            ->groupBy('segmento')
            ->get();

        return [
            'series' => $alunosSerie,
            'segmentos' => $alunosSegmento
        ];
    }

    public function getAlunosTurmaReport()
    {
        $matriculados = Turma::join('aluno_turmas', 'aluno_turmas.turma_id', '=', 'turmas.id')
        ->select('turmas.nome as turma_nome', DB::raw('COUNT(aluno_turmas.id) as tot_alunos'))
        ->groupBy('turmas.nome')
        ->get();

        return $matriculados;
    }

    public function getAlunosIrmaosReport($nome_pai_mae)
    {
        $irmaos = Aluno::leftJoin('aluno_turmas', 'aluno_turmas.aluno_id', '=', 'alunos.id')
            ->leftJoin('turmas', 'turmas.id', '=', 'aluno_turmas.turma_id')
            ->join('series', 'series.id', '=', 'alunos.serie_id')
            ->select('alunos.nome_completo', 'series.nome as serie', 'turmas.nome as turma_nome')
            ->where(DB::raw('UPPER(nome_pai)', '=', $nome_pai_mae))
            ->orWhere(DB::raw('UPPER(nome_mae)', '=', $nome_pai_mae))
            ->groupBy('alunos.nome_completo', 'series.nome', 'turmas.nome')
            ->get();

        return $irmaos;
    }
}
