<div class="card col-xl-7 p-0 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($cliente)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Cliente</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Cliente</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($cliente)
            <form method="POST" action="{{ route('clientes.update', $cliente->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('clientes.store') }}">
        @endif

            @csrf
            @include('clientes.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($cliente) ? $cliente->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($cliente) ? $cliente->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('clientes.actions')
        </div>
    </div>
</div>
