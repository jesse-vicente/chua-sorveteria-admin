<div class="card col-xl-7 mx-auto">
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
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($condicaoPagamento) ? $condicaoPagamento->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($condicaoPagamento) ? $condicaoPagamento->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('condicoes-pagamento.actions')
        </div>
    </div>
</div>
