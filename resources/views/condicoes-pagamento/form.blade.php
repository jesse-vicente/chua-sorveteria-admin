<div class="card">
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
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($condicaoPagamento) ? $condicaoPagamento->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($condicaoPagamento) ? $condicaoPagamento->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('condicoes-pagamento.actions')
