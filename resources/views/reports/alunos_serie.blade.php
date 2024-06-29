@extends('layouts.reports')

@section('title', 'Relatório Por Série e Segmento')

@section('content')

    <div class="row">
    
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Série</th>
                    <th>Total Alunos</th>
                </tr>
            </thead>    
            <tfoot>
                <tr>
                    <th>Série</th>
                    <th>Total Alunos</th>
                </tr>
            </tfoot>    
            <tbody>
                @forelse($data['series'] as $item)
                    <tr>
                        <td>{{$item->serie_nome}}</td>
                        <td>{{$item->tot_alunos}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Nenhum registro encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        <hr>
    
        <table class="table table-striped table-responsive mt-5">
            <thead>
                <tr>
                    <th>Segmento</th>
                    <th>Total Alunos</th>
                </tr>
            </thead>    
            <tfoot>
                <tr>
                    <th>Segmento</th>
                    <th>Total Alunos</th>
                </tr>
            </tfoot>    
            <tbody>
                @forelse($data['segmentos'] as $item)
                    <tr>
                        <td>{{$item->segmento}}</td>
                        <td>{{$item->tot_alunos}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Nenhum registro encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    

@endsection
