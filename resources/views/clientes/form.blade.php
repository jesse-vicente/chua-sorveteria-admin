<div class="card">
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
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($cliente) ? $cliente->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($cliente) ? $cliente->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('clientes.actions')
