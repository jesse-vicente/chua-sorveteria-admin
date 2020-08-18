<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($compra)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Compra</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Compra</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($compra)
            <form method="POST" action="{{ route('compras.update', $compra->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('compras.store') }}">
        @endif

            @csrf
            @include('compras.fields')
            </form>
    </div>
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($compra) ? $compra->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($compra) ? $compra->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('compras.actions')
