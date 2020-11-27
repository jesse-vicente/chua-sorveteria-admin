<div class="card col-xl-6 p-0 mx-auto">
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
            <form method="POST" key="{{ $compra->getPrimaryKeyStr() }}" action="{{ route('compras.update', $compra->getPrimaryKeyStr()) }}" id="form-cancel">
                @method('PUT')
        @else
            <form method="POST" id="form-compra">
        @endif

                @csrf
                @include('compras.fields')

                <div class="d-flex justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($compra) ? $compra->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($compra) ? $compra->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                    @empty($compra)
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>
                    @else
                        <button type="button" class="btn btn-danger mr-2" id="btn-cancel">
                            <span class="text-bold">Cancelar Compra</span>
                        </button>
                    @endempty
                        <a class="btn btn-outline-secondary" href="{{ route('compras.index') }}">
                            <span class="text-bold">Voltar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>
