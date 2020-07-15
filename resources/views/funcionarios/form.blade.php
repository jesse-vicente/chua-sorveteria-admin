<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($funcionario)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Funcionário</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Funcionário</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($funcionario)
            <form method="POST" action="{{ route('funcionarios.update', $funcionario->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('funcionarios.store') }}">
        @endif

            @csrf
            @include('funcionarios.fields')
            </form>
    </div>
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($funcionario) ? $funcionario->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($funcionario) ? $funcionario->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('funcionarios.actions')
