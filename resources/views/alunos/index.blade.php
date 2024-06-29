@extends('layouts.app')

@section('title', 'Alunos')

@section('actions')
<a href="{{route('alunos.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Novo Aluno
</a>
@endsection

@section('content')

    <div class="table-responsive">
        <table class="table table-bordered overflow-x" id="alunos-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Nascimento</th>
                    <th>Série</th>
                    <th>Pai</th>
                    <th>Mãe</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Nascimento</th>
                    <th>Série</th>
                    <th>Pai</th>
                    <th>Mãe</th>
                    <th>Ações</th>
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este aluno?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="{{ route('alunos.destroy', ['aluno' => 0]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="id-aluno">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link href="{{asset('template/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('scripts')

<script src="{{asset('template/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('template/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var alunoId = button.data('id');
        var action = $('#deleteForm').attr('action').replace('/0', '/' + alunoId);
        $('#deleteForm').attr('action', action);
    });

    function showDeleteModal(id) {
        $('#id-aluno').val(id);
        $('#deleteModal').show();
    }

    $(document).ready(function() {
        $('#alunos-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url:"https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
            },
            ajax: "{{ route('alunos.datatable') }}",
            columns: [
                { data: 'matricula', name: 'matricula' },
                { data: 'nome_completo', name: 'nome_completo' },
                { data: 'nascimento', name: 'data_nascimento', searchable: false },
                { data: 'serie.nome', name: 'series.nome' },
                { data: 'nome_pai', name: 'nome_pai' },
                { data: 'nome_mae', name: 'nome_mae' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection