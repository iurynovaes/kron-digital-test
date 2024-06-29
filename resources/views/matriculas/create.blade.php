@extends('layouts.app')

@section('title', 'Matrículas')

@section('content')

<div class="col-md-12">
    <form class="user" action="{{ route('matriculas.create') }}" method="POST">
        @csrf
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select class="form-control "
                        id="serie" aria-describedby="Séries"
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
            <div class="col-12" id="alunos-disponiveis">
                <b>Alunos Disponíveis</b>
                <ul class="list-group overflow-auto">
                    <!-- Lista de alunos será preenchida dinamicamente via AJAX -->
                </ul>
            </div>
        </div>

        <div class="row mt-5 w-100" id="turmas-boxes"></div>
    
    </form>
</div>

@endsection

@section('scripts')
<script>

    var alunoId;
    var turmaId;

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        let el = document.getElementById(data);
        let targetId = $(ev.target).attr('id');
        let target = document.getElementById(targetId);

        // Se soltar em cima de um item da lista, ele transfere o target para o UL
        if(target.tagName == 'LI') {
            target = document.getElementById(targetId).parentNode;
        } else {
            target = document.getElementById(targetId);
        }

        let clone = document.getElementById(data).cloneNode();
        clone.innerHTML = el.innerHTML + '<span class="badge badge-danger badge-pill" onclick="removerAlunoTurma(this.parentNode);" style="cursor:pointer"><i class="fa fa-sm fa-trash p-2"></i></span>';

        $(clone).attr('id', 'aluno-turma-' + $(el).data('aluno-id'));
        $(clone).addClass('aluno-turma d-flex justify-content-between align-items-center');

        alunoId = $(clone).data('aluno-id')
        target.appendChild(clone);
        turmaId = $(target).data('turma-id');
        $(clone).data('turma-id', turmaId);

        $.ajax({
            url: '{{route('matriculas.create')}}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                aluno_id: alunoId,
                turma_id: turmaId,
            },
            success: function(response) {
                if (response.success) {
                    alert('TUDO CERTO: ' + response.message);
                } else {
                    alert('ATENÇÃO: ' + response.message);
                    target.removeChild(target.lastElementChild);
                }
            },
            error: function(xhr, status, error) {
                alert('ERRO: ' + error);
                target.removeChild(target.lastElementChild);
            }
        });
    }

    function removerAlunoTurma(el) {

        alunoId = $(el).data('aluno-id');
        turmaId = $(el).data('turma-id');

        $.ajax({
            url: '{{route('matriculas.delete')}}',
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                aluno_id: alunoId,
                turma_id: turmaId,
            },
            success: function(response) {
                if (response.success) {
                    alert('TUDO CERTO: ' + response.message);
                    $(el).remove();
                } else {
                    alert('ATENÇÃO: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('ERRO: ' + error);
            }
        });
    }

    $(document).ready(function() {

        $('#serie').on('change', function() {
            var serieId = $(this).val();

            $.ajax({
                url: '{{route('alunos.ajax')}}?serie=' + serieId,
                method: 'GET',
                success: function(response) {
                    var alunos = response.alunos;

                    $('#alunos-disponiveis ul').empty();

                    $.each(alunos, function(index, aluno) {
                        $('#alunos-disponiveis ul').append('<li class="list-group-item" id="aluno-' + aluno.id + '" data-aluno-id="' + aluno.id + '" draggable="true" ondragstart="drag(event)">' + aluno.nome_completo + '</li>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar alunos: ' + error);
                }
            });

            $.ajax({
                url: '{{route('turmas.ajax')}}?serie=' + serieId,
                method: 'GET',
                success: function(response) {
                    var turmas = response.turmas;

                    $('#turmas-boxes').empty();

                    $.each(turmas, function(index, turma) {
                        let alunosLi = '';
                        for (a of turma.alunos) {
                            alunosLi += '<li class="list-group-item aluno-turma d-flex justify-content-between align-items-center" id="aluno-' + a.id + '-turma-' + turma.id + '" data-aluno-id="' + a.id + '" data-turma-id="' + turma.id + '" draggable="true" ondragstart="drag(event)">' + a.nome_completo + '<span class="badge badge-danger badge-pill" onclick="removerAlunoTurma(this.parentNode);" style="cursor:pointer"><i class="fa fa-sm fa-trash p-2"></i></span></li>';
                        }
                        $('#turmas-boxes').append('<div class="col-md-4 text-center"><h6>'+turma.nome+' ('+String(turma.turno).toUpperCase()+')</h6><b>Máx. vagas: '+turma.vagas+'</b><ul id="turma-'+turma.id+'" class="turma-box p-0" data-turma-id="'+turma.id+'" ondrop="drop(event)" ondragover="allowDrop(event)">'+alunosLi+'</ul></div>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar turmas: ' + error);
                }
            });
        });
    });

</script>

<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

@endsection

@section('styles')
<style>
    #turmas-boxes {
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .turma-box {
        width:100%;
        height:300px;
        background:#a8bba8;
        border-radius: 25px;
        overflow: auto;
    }
    #alunos-disponiveis ul {
        max-height:150px;
    }
    #trash-box {
        width: 100%;
        height: 100px;
        background: rgba(201, 69, 69, .6);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endsection