<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Ensina Aí</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('view-secretaria')
    <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @endcan

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestão
    </div>

    @can('view-secretaria')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeries"
            aria-expanded="true" aria-controls="collapseSeries">
            <i class="fas fa-fw fa-pencil"></i>
            <span>Matrículas</span>
        </a>
        <div id="collapseSeries" class="collapse" aria-labelledby="headingSeries" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                <a class="collapse-item" href="{{route('matriculas.index')}}">Matricular Alunos</a>
            </div>
        </div>
    </li>
    @endcan
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Alunos</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                <a class="collapse-item" href="{{ route('alunos.create') }}">Cadastro</a>
                <a class="collapse-item" href="{{ route('alunos.index') }}">Listagem</a>
            </div>
        </div>
    </li>

    @can('view-turma')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTurmas"
            aria-expanded="true" aria-controls="collapseTurmas">
            <i class="fas fa-fw fa-chalkboard-user"></i>
            <span>Turmas</span>
        </a>
        <div id="collapseTurmas" class="collapse" aria-labelledby="headingTurmas" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Utilities:</h6> --}}
                <a class="collapse-item" href="{{ route('turmas.create') }}">Cadastro</a>
                <a class="collapse-item" href="{{ route('turmas.index') }}">Listagem</a>
            </div>
        </div>
    </li>
    @endcan

    @can('view-relatorio')
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Informativo
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRelatorio"
            aria-expanded="true" aria-controls="collapseRelatorio">
            <i class="fas fa-fw fa-print"></i>
            <span>Relatórios</span>
        </a>
        <div id="collapseRelatorio" class="collapse" aria-labelledby="headingRelatorio" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                <a class="collapse-item" href="{{ route('reports.index') }}">Extrair Relatório</a>
            </div>
        </div>
    </li>
    @endcan
</ul>
<!-- End of Sidebar -->