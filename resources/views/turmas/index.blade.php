@extends('layouts.app')

@section('title', 'Turmas')

@section('actions')
<a href="{{route('turmas.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Nova Turma
</a>
@endsection

@section('content')

    <div class="table-responsive">
        <table class="table table-bordered overflow-x" id="turmas-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ano Letivo</th>
                    <th>Série</th>
                    <th>Turno</th>
                    <th>Vagas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Ano Letivo</th>
                    <th>Série</th>
                    <th>Turno</th>
                    <th>Vagas</th>
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
                    Tem certeza que deseja excluir esta turma?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="{{ route('turmas.destroy', ['turma' => 0]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="id-turma">
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
        var turmaId = button.data('id');
        var action = $('#deleteForm').attr('action').replace('/0', '/' + turmaId);
        $('#deleteForm').attr('action', action);
    });

    function showDeleteModal(id) {
        $('#id-turma').val(id);
        $('#deleteModal').show();
    }

    $(document).ready(function() {
        $('#turmas-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url:"https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
            },
            ajax: "{{ route('turmas.datatable') }}",
            columns: [
                { data: 'nome', name: 'nome' },
                { data: 'ano_letivo', name: 'ano_letivo'},
                { data: 'serie.nome', name: 'series.nome' },
                { data: 'turno', name: 'turno' },
                { data: 'vagas', name: 'vagas' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection