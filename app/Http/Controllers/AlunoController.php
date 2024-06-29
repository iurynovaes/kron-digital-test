<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Endereco;
use App\Models\Serie;
use App\Models\TipoEndereco;
use App\Services\CreateEnderecoAlunoService;
use App\Services\EnderecoAlunoService;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class AlunoController extends Controller
{
    public function index()
    {
        return view('alunos.index');
    }

    public function alunosDatatable(Request $request)
    {
        $alunos = Aluno::with('serie')->select('alunos.*', DB::raw('DATE_FORMAT(data_nascimento, "%d/%m/%Y") as nascimento'));

        return DataTables::of($alunos)
            ->addColumn('actions', function($row){
                $editUrl = route('alunos.edit', $row->id);
                // $deleteUrl = route('alunos.destroy', $row->id);
                // $viewUrl = route('alunos.show', $row->id); <a href="' . $viewUrl . '" class="btn btn-sm btn-primary">Ver</a>
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Ver</a>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="'.$row->id.'">Excluir</button>
                    ';
                    
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->search['value'] != '') {
                    $searchValue = $request->search['value'];
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('matricula', 'like', "%{$searchValue}%")
                                ->orWhere('nome_completo', 'like', "%{$searchValue}%")
                                ->orWhere('nome_pai', 'like', "%{$searchValue}%")
                                ->orWhere('nome_mae', 'like', "%{$searchValue}%")
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
        $series = Serie::pluck('nome', 'id')->toArray();
        $tipoEnderecos = TipoEndereco::pluck('tipo', 'id')->toArray();

        return view('alunos.create', compact('series', 'tipoEnderecos'));
    }

    public function store(Request $request)
    {
        $validate = $this->getValidateData();

        $request->validate($validate['rules'], $validate['messages']);

        try {

            $data = $request->all();

            DB::beginTransaction();
    
            $aluno = Aluno::create($data);
    
            $enderecoService = new EnderecoAlunoService($aluno, $data);
            $enderecoAluno = $enderecoService->createEnderecoAluno();
    
            if (empty($enderecoAluno)) {
    
                DB::rollBack();

                return redirect()->back()->with('alert_bag', [
                    'success' => false,
                    'message' => 'Falha ao criar endereço do aluno'
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('alunos.index')->with('alert_bag', [
                'success' => true,
                'message' => 'Aluno criado com sucesso'
            ]);

        } catch (Throwable $th) {
            DB::rollBack();
            
            return redirect()->back()->with('alert_bag', [
                'success' => false,
                'message' => 'Falha ao criar aluno'
            ]);
        }
    }

    private function getValidateData(): array
    {
        $rules = [
            'nome_completo' => 'required|max:50',
            'data_nascimento' => 'required',
            'serie_id' => 'required|exists:series,id',
            'nome_pai' => 'required|max:50',
            'nome_mae' => 'required|max:50',
            'cep' => 'required|numeric|digits:8',
            'rua' => 'required',
            'numero' => 'required|max:10',
            'complemento' => 'max:20',
            'tipo_endereco_id' => 'required|exists:tipo_enderecos,id',
        ];

        $messages = [
            'nome_completo.required' => 'Nome é obrigatório',
            'nome_completo.max'      => 'Nome deve ter no máximo 50 caracteres',

            'data_nascimento.required' => 'Data Nascimento é obrigatório',

            'serie_id.required' => 'Série é obrigatório',
            'serie_id.exists' => 'Série não encontrada',

            'nome_pai.required' => 'Nome Pai é obrigatório',
            'nome_pai.max' => 'Nome Pai deve ter no máximo 50 caracteres',

            'nome_mae.required' => 'Nome Mãe é obrigatório',
            'nome_mae.max' => 'Nome Mãe deve ter no máximo 50 caracteres',
            
            'cep.required' => 'CEP é obrigatório',
            'cep.numeric' => 'CEP deve ser números somente',
            'cep.digits' => 'CEP deve ter 8 caracteres',
            
            'rua.required' => 'Rua é obrigatório',
            
            'numero.required' => 'Número é obrigatório',
            'numero.max' => 'Número deve ter no máximo 10 caracteres',
            
            'complemento.max' => 'Complemento deve ter no máximo 20 caracteres',
            
            'tipo_endereco_id.required' => 'Tipo Endereço é obrigatório',
            'tipo_endereco_id.exists' => 'Tipo Endereço não encontrado',
        ];

        return [
            'rules' => $rules,
            'messages' => $messages
        ];
    }
    
    public function edit(Aluno $aluno)
    {
        $series = Serie::pluck('nome', 'id')->toArray();
        $tipoEnderecos = TipoEndereco::pluck('tipo', 'id')->toArray();

        return view('alunos.create', compact('series', 'tipoEnderecos', 'aluno'));
    }

    public function update(Aluno $aluno, Request $request)
    {
        $validate = $this->getValidateData();

        $request->validate($validate['rules'], $validate['messages']);

        try {

            $data = $request->all();

            DB::beginTransaction();
    
            $aluno->update($data);

            $enderecoService = new EnderecoAlunoService($aluno, $data);
            $enderecoAluno = $enderecoService->updateEnderecoAluno();
    
            if (empty($enderecoAluno)) {
    
                DB::rollBack();
                
                return redirect()->back()->with('alert_bag', [
                    'success' => false,
                    'message' => 'Falha ao atualizar o endereço do aluno'
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('alunos.index')->with('alert_bag', [
                'success' => true,
                'message' => 'Aluno atualizado com sucesso'
            ]);

        } catch (Throwable $th) {

            DB::rollBack();

            return redirect()->back()->with('alert_bag', [
                'success' => false,
                'message' => 'Falha ao atualizar o aluno'
            ]);
        }
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()->route('alunos.index')->with('alert_bag', [
            'success' => true,
            'message' => 'Aluno excluído com sucesso'
        ]);
    }

    public function getAlunos(Request $request)
    {
        $serie = $request->input('serie');

        $alunos = Aluno::select('alunos.*');

        if (!empty($serie)) {
            $alunos = $alunos->where('serie_id', $serie);
        }

        $alunos = $alunos->get();

        return response()->json(['alunos' => $alunos]);
    }
}
