@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')

    <form class="user" action="{{ route('reports.post') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select class="form-control "
                        id="report" name="report" aria-describedby="Relatório"
                        placeholder="Relatório" required>
                        <option value="">Relatório</option>
                        @foreach($reports as $id => $value)
                            <option value="{{$id}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row d-none" id="nome_pai_mae">
            <div class="col-12">
                <div class="form-group">    
                    <input type="text" class="form-control"
                        name="nome_pai_mae" aria-describedby="Nome do Pai ou Mãe"
                        placeholder="Nome do Pai ou Mãe" maxlength="50">
                </div>
            </div>
        </div>

        <div class="text-right mt-5">
            <button type="submit" class="btn btn-success">
                Gerar  
            </button>
        </div>
    </form>

@endsection

@section('scripts')
<script>

    $('#report').on('change', function() {
        if ($(this).val() == 'alunos_irmaos') {
            $('#nome_pai_mae').removeClass('d-none');
        } else {
            $('#nome_pai_mae').addClass('d-none');
        }
    });

</script>
@endsection