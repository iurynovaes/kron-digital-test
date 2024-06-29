@extends('layouts.reports')

@section('title', 'Relatório de Turmas')

@section('content')
    
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Turma</th>
                <th>Total de alunos</th>
            </tr>
        </thead>    
        <tfoot>
            <tr>
                <th>Turma</th>
                <th>Total de alunos</th>
            </tr>
        </tfoot>    
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{$item->turma_nome}}</td>
                    <td>{{$item->tot_alunos}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Nenhum registro encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
