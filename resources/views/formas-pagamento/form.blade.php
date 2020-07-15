<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($formaPagamento)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Forma de Pagamento</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Forma de Pagamento</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($formaPagamento)
            <form method="POST" action="{{ route('formas-pagamento.update', $formaPagamento->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('formas-pagamento.store') }}">
        @endif

                @csrf
                @include('formas-pagamento.fields')
            </form>
    </div>
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($formaPagamento) ? $formaPagamento->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($formaPagamento) ? $formaPagamento->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('formas-pagamento.actions')
