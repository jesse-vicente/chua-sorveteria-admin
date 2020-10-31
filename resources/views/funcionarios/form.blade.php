<div class="card col-xl-7 p-0 mx-auto">
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

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($funcionario) ? $funcionario->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($funcionario) ? $funcionario->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('funcionarios.actions')
        </div>
    </div>
</div>

@include('cidades.create-modal')
