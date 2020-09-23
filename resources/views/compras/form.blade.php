<div class="card col-xl-7 p-0">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($compra)
                <i class="fa fa-times-circle"></i>
                <h3 class="ml-3 mb-0">Cancelar Compra</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Compra</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($compra)
            <form method="POST" key="{{ $compra->getPrimaryKey() }}" action="{{ route('compras.update', $compra->getPrimaryKey()) }}" id="form-cancel">
                @method('PUT')
        @else
            <form method="POST" id="form-compra">
        @endif

                @csrf
                @include('compras.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($compra) ? $compra->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Cancelado em: </b>{{ isset($compra) ? $compra->getDataCancelamento() : "__/__/____" }}</small>
            </div>

            @empty($compra)
                @include('compras.actions')
            @else
            <div class="btn-group-lg">
                <button class="btn btn-danger mr-2" id="btn-cancel">
                    <span class="text-bold">Cancelar Compra</span>
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('compras.index') }}">
                    <span class="text-bold">Voltar</span>
                </a>
            </div>
            @endempty
        </div>
    </div>
</div>
