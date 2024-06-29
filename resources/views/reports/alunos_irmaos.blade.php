@extends('layouts.reports')

@section('title', 'Relatório de Irmãos')

@section('content')

    <h6>Filtro Nome Pai/Mãe: {{$nome_pai_mae}}</h6><br>

    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Série</th>
                <th>Turma</th>
            </tr>
        </thead>    
        <tfoot>
            <tr>
                <th>Aluno</th>
                <th>Série</th>
                <th>Turma</th>
            </tr>
        </tfoot>    
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{$item->nome_completo}}</td>
                    <td>{{$item->serie}}</td>
                    <td>{{$item->turma_nome}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhum registro encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
