<?php

namespace App\Http\Controllers;

use App\Enums\Turno;
use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Serie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class TurmaController extends Controller
{
    public function index()
    {
        if (! Gate::allows('view-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        return view('turmas.index');
    }

    public function turmasDatatable(Request $request)
    {
        if (! Gate::allows('view-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $turmas = Turma::with('serie')->select('turmas.*', DB::raw('UPPER(turmas.turno) as turno'));

        return DataTables::of($turmas)
            ->addColumn('actions', function($row){
                $editUrl = route('turmas.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Ver</a>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="'.$row->id.'">Excluir</button>
                    ';
                    
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->search['value'] != '') {
                    $searchValue = $request->search['value'];
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('nome', 'like', "%{$searchValue}%")
                                ->orWhere('ano_letivo', 'like', "%{$searchValue}%")
                                ->orWhere('turno', 'like', "%{$searchValue}%")
                                ->orWhereHas('serie', function ($query) use ($searchValue) {
                                    $query->where('nome', 'like', "%{$searchValue}%");
                                });
                    });
                }
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        if (! Gate::allows('create-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $series = Serie::pluck('nome', 'id')->toArray();
        $turnos = Turno::toArray();

        return view('turmas.create', compact('series', 'turnos'));
    }

    public function store(Request $request)
    {
        if (! Gate::allows('create-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $validate = $this->getValidateData();

        $request->validate($validate['rules'], $validate['messages']);

        try {

            $data = $request->all();
    
            $turma = Turma::create($data);
    
            return redirect()->route('turmas.index')->with('alert_bag', [
                'success' => true,
                'message' => 'Turma criada com sucesso'
            ]);

        } catch (Throwable $th) {
            
            return redirect()->back()->with('alert_bag', [
                'success' => false,
                'message' => 'Falha ao criar turma'
            ]);
        }
    }

    private function getValidateData(): array
    {
        $rules = [
            'nome' => 'required|max:50',
            'serie_id' => 'required|exists:series,id',
            'turno' => 'required',
            'vagas' => 'required|numeric|min:1',
            'ano_letivo' => 'required|numeric|digits:4',
        ];

        $messages = [
            'nome.required' => 'Nome é obrigatório',
            'nome.max'      => 'Nome deve ter no máximo 50 caracteres',

            'turno.required' => 'Data Nascimento é obrigatório',

            'serie_id.required' => 'Série é obrigatório',
            'serie_id.exists' => 'Série não encontrada',
            
            'ano_letivo.required' => 'Ano letivo é obrigatório',
            'ano_letivo.numeric' => 'Ano letivo deve ser números somente',
            'ano_letivo.digits' => 'Ano letivo deve ter 4 dígitos',
            
            'vagas.required' => 'Vagas é obrigatório',
            'vagas.max' => 'Vagas deve ter no mínimo 1',
        ];

        return [
            'rules' => $rules,
            'messages' => $messages
        ];
    }
    
    public function edit(Turma $turma)
    {
        if (! Gate::allows('update-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $series = Serie::pluck('nome', 'id')->toArray();
        $turnos = Turno::toArray();

        return view('turmas.create', compact('series', 'turnos', 'turma'));
    }

    public function update(Turma $turma, Request $request)
    {
        if (! Gate::allows('update-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $validate = $this->getValidateData();

        $request->validate($validate['rules'], $validate['messages']);

        try {

            $data = $request->all();
    
            $turma->update($data);
    
            return redirect()->route('turmas.index')->with('alert_bag', [
                'success' => true,
                'message' => 'Turma atualizada com sucesso'
            ]);

        } catch (Throwable $th) {

            return redirect()->back()->with('alert_bag', [
                'success' => false,
                'message' => 'Falha ao atualizar o turma'
            ]);
        }
    }

    public function destroy(Turma $turma)
    {
        if (! Gate::allows('delete-turma')) {
            return redirect()->route('home')->with('alert_bag', [
                'success' => false,
                'message' => 'Acesso negado! Você não tem permissão para acessar este recurso.'
            ]);
        }

        $turma->delete();

        return redirect()->route('turmas.index')->with('alert_bag', [
            'success' => true,
            'message' => 'Turma excluída com sucesso'
        ]);
    }

    public function getTurmas(Request $request)
    {
        $serie = $request->input('serie');

        $turmas = Turma::with('alunos')->select('turmas.*');

        if (!empty($serie)) {
            $turmas = $turmas->where('turmas.serie_id', $serie);
        }

        $turmas = $turmas->orderBy('turmas.turno')
            ->orderBy('turmas.nome')
            ->get();

        return response()->json(['turmas' => $turmas]);
    }
}
