@extends('layouts.app')

@section('title', 'Cadastro de Turmas')

@section('content')

<div class="col-md-12">
    <form class="user" action="{{ isset($turma) ? route('turmas.update', $turma->id) : route('turmas.store') }}" method="POST">
        @csrf
    
        @if(isset($turma))
            @method('put')
        @endif
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">    
                    <input type="text" class="form-control "
                        name="nome" aria-describedby="Nome da turma"
                        placeholder="Nome da turma" maxlength="50" @if(isset($turma)) value="{{$turma->nome}}" @endif required>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select class="form-control "
                        name="serie_id" aria-describedby="Séries"
                        placeholder="Série" required>
                        <option value="">Série</option>
                        @foreach($series as $id => $value)
                            <option value="{{$id}}" @if(isset($turma->serie_id) && $turma->serie_id == $id) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <input type="number" class="form-control "
                        name="vagas" aria-describedby="Nº de Vagas"
                        placeholder="Nº de vagas" minlength="1" min="1" @if(isset($turma)) value="{{$turma->vagas}}" @endif required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <input type="number" class="form-control"
                        name="ano_letivo" aria-describedby="Ano letivo"
                        placeholder="Ano letivo" @if(isset($turma)) value="{{$turma->ano_letivo}}" @endif required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select class="form-control "
                        name="turno" aria-describedby="Turno"
                        placeholder="Turno" required>
                        <option value="">Turno</option>
                        @foreach($turnos as $id => $value)
                            <option value="{{$id}}" @if(isset($turma->turno) && $turma->turno == $id) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="text-right">
            <button type="submit" class="btn btn-success">
                Salvar  
            </button>
        </div>
    </form>
</div>

@endsection