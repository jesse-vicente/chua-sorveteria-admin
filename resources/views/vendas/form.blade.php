<div class="card col-xl-7 p-0 mx-auto">
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
            <form method="POST" key="{{ $venda->getPrimaryKeyStr() }}" action="{{ route('vendas.update', $venda->getPrimaryKeyStr()) }}" id="form-cancel">
                @method('PUT')
        @else
            <form method="POST" id="form-venda">
        @endif

                @csrf
                @include('vendas.fields')

                <div class="d-flex justify-content-between border-top mt-4" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($venda) ? $venda->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($venda) ? $venda->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                    @empty($venda)
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>
                    @else
                        <button type="button" class="btn btn-danger mr-2" id="btn-cancel">
                            <span class="text-bold">Cancelar Venda</span>
                        </button>
                    @endempty
                        <a class="btn btn-outline-secondary" href="{{ route('vendas.index') }}">
                            <span class="text-bold">Voltar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>

@include('clientes.create-modal')
