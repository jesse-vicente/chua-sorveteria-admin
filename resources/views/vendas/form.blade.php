<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($venda)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Venda</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Venda</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($venda)
            <form method="POST" action="{{ route('vendas.update', $venda->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('vendas.store') }}">
        @endif

            @csrf
            @include('vendas.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($venda) ? $venda->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($venda) ? $venda->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('vendas.actions')
        </div>
    </div>
</div>
