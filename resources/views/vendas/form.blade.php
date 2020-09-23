<div class="card col-xl-7 p-0">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($venda)
                <i class="fa fa-times-circle"></i>
                <h3 class="ml-3 mb-0">Cancelar Venda</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Venda</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($venda)
            <form method="POST" key="{{ $venda->getPrimaryKey() }}" action="{{ route('vendas.update', $venda->getPrimaryKey()) }}" id="form-cancel">
                @method('PUT')
        @else
            <form method="POST" id="form-venda">
        @endif

                @csrf
                @include('vendas.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($venda) ? $venda->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Cancelado em: </b>{{ isset($venda) ? $venda->getDataCancelamento() : "__/__/____" }}</small>
            </div>

            @empty($venda)
                @include('vendas.actions')
            @else
            <div class="btn-group-lg">
                <button class="btn btn-danger mr-2" id="btn-cancel">
                    <span class="text-bold">Cancelar Venda</span>
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('vendas.index') }}">
                    <span class="text-bold">Voltar</span>
                </a>
            </div>
            @endempty
        </div>
    </div>
</div>
