<div class="card col-xl-8 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($condicaoPagamento)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Condição Pagamento</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Condição Pagamento</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($condicaoPagamento)
            <form method="POST" action="{{ route('condicoes-pagamento.update', $condicaoPagamento->getId()) }}" id="form-condicao-pagamento">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('condicoes-pagamento.store') }}" id="form-condicao-pagamento">
        @endif

                @csrf
                @include('condicoes-pagamento.fields')

                <div class="d-flex justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($condicaoPagamento) ? $condicaoPagamento->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($condicaoPagamento) ? $condicaoPagamento->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>

                        <a class="btn btn-outline-secondary" href="{{ route('condicoes-pagamento.index') }}">
                            <span class="text-bold">Cancelar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>

@include('formas-pagamento.create-modal')
