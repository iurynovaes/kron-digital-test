@extends('layouts.app')

@section('title', 'Cadastro de Alunos')

@section('content')

<div class="col-md-12">
    <form class="user" action="{{ isset($aluno) ? route('alunos.update', $aluno->id) : route('alunos.store') }}" method="POST">
        @csrf
    
        @if(isset($aluno))
            @method('put')
        
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" class="form-control " aria-describedby="Matrícula do aluno" value="Matrícula - {{$aluno->matricula}}" readonly>
                    </div>
                </div>
            </div>
        @endif
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="text" class="form-control "
                        name="nome_completo" aria-describedby="Nome do aluno"
                        placeholder="Nome" maxlength="50" @if(isset($aluno)) value="{{$aluno->nome_completo}}" @endif required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <input type="date" class="form-control "
                        name="data_nascimento" aria-describedby="Data de nascimento"
                        placeholder="Data Nascimento" max="{{date('Y-m-d', strtotime('-3 year'))}}" @if(isset($aluno)) value="{{$aluno->data_nascimento}}" @endif required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <select class="form-control "
                        name="serie_id" aria-describedby="Séries"
                        placeholder="Série" required>
                        <option value="">Série</option>
                        @foreach($series as $id => $value)
                            <option value="{{$id}}" @if(isset($aluno->serie_id) && $aluno->serie_id == $id) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <input type="text" class="form-control "
                        name="nome_pai" aria-describedby="Nome do pai"
                        placeholder="Nome do Pai" maxlength="50" @if(isset($aluno)) value="{{$aluno->nome_pai}}" @endif required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <input type="text" class="form-control "
                        name="nome_mae" aria-describedby="Nome da mãe"
                        placeholder="Nome da Mãe" maxlength="50" @if(isset($aluno)) value="{{$aluno->nome_mae}}" @endif required>
                </div>
            </div>
        </div>
    
        <hr>
    
        <h6>Endereço</h6>
        
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <input type="text" class="form-control "
                        name="cep" aria-describedby="CEP"
                        placeholder="CEP (somente números)" minlength="8" maxlength="8" @if(isset($aluno)) value="{{$aluno->getEnderecoCompleto()->cep}}" @endif required>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <input type="text" class="form-control "
                        name="rua" aria-describedby="Rua"
                        placeholder="Rua" @if(isset($aluno)) value="{{$aluno->getEnderecoCompleto()->rua}}" @endif required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <input type="number" class="form-control "
                        name="numero" aria-describedby="Número"
                        placeholder="Número" maxlength="10" @if(isset($aluno)) value="{{$aluno->getEnderecoCompleto()->numero}}" @endif required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <input type="text" class="form-control "
                        name="complemento" aria-describedby="Complemento"
                        placeholder="Complemento" maxlength="20" @if(isset($aluno)) value="{{$aluno->getEnderecoCompleto()->complemento}}" @endif>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select class="form-control "
                        name="tipo_endereco_id" aria-describedby="Tipo Endereço"
                        placeholder="Tipo Endereço" required>
                        <option value="">Tipo Endereço</option>
                        @foreach($tipoEnderecos as $id => $value)
                            <option value="{{$id}}" @if(isset($aluno) && $aluno->getEnderecoCompleto()->tipo_endereco_id == $id) selected @endif>{{$value}}</option>
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