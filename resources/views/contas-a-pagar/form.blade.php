<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                @isset($contaPagar)
                    <i class="fa fa-money-check"></i>
                    <h3 class="ml-3 mb-0">Pagamento</h3>
                @else
                    <i class="fa fa-plus"></i>
                    <h3 class="ml-3 mb-0">Cadastrar Conta à Pagar</h3>
                @endif
            </div>
        </div>

        <div class="card-body">
            @isset($contaPagar)
                <form method="POST" id="form-conta" action="{{ route('contas-a-pagar.update', $contaPagar->getPrimaryKey()) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('contas-a-pagar.store') }}">
            @endif

                @csrf
                @include('contas-a-pagar.fields')
                </form>
        </div>

        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column text-secondary">
                    <small><b>Cadastrado em: </b>{{ isset($contaPagar) ? $contaPagar->getDataCadastro() : "__/__/____" }}</small>
                    <small><b>Alterado em: </b>{{ isset($contaPagar) ? $contaPagar->getDataAlteracao() : "__/__/____" }}</small>
                </div>

                @empty($contaPagar)
                    @include('contas-a-pagar.actions')
                @else
                <div class="btn-group-lg">
                    <button type="submit" class="btn btn-success mr-2">
                        <span class="text-bold">Salvar</span>
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('contas-a-pagar.index') }}">
                        <span class="text-bold">Cancelar</span>
                    </a>
                </div>
                @endempty
            </div>
        </div>
    </div>
</div>
