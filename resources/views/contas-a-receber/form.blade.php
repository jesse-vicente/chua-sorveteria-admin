<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                @isset($contaReceber)
                    <i class="fa fa-money-check"></i>
                    <h3 class="ml-3 mb-0">Pagamento</h3>
                @else
                    <i class="fa fa-plus"></i>
                    <h3 class="ml-3 mb-0">Cadastrar Conta à Receber</h3>
                @endif
            </div>
        </div>

        <div class="card-body">
            @isset($contaReceber)
                <form method="POST" id="form-conta" action="{{ route('contas-a-receber.update', $contaReceber->getPrimaryKey()) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('contas-a-receber.store') }}">
            @endif

                @csrf
                @include('contas-a-receber.fields')
                </form>
        </div>

        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column text-secondary">
                    <small><b>Cadastrado em: </b>{{ isset($contaReceber) ? $contaReceber->getDataCadastro() : "__/__/____" }}</small>
                    <small><b>Alterado em: </b>{{ isset($contaReceber) ? $contaReceber->getDataAlteracao() : "__/__/____" }}</small>
                </div>

                @empty($contaReceber)
                    @include('contas-a-receber.actions')
                @else
                <div class="btn-group-lg">
                    <button class="btn btn-success mr-2" id="btn-pagar">
                        <span class="text-bold">Finalizar</span>
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('contas-a-receber.index') }}">
                        <span class="text-bold">Cancelar</span>
                    </a>
                </div>
                @endempty
            </div>
        </div>
    </div>
</div>
