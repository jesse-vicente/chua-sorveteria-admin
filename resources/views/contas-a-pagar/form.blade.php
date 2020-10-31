<div class="col-xl-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                @isset($contaPagar)
                    @if ($contaPagar->getStatus() == 'Pago')
                        <i class="fa fa-ban"></i>
                        <h3 class="ml-3 mb-0">Cancelar Pagamento</h3>
                    @else
                        <i class="fa fa-check"></i>
                        <h3 class="ml-3 mb-0">Confirmar Pagamento</h3>
                    @endif
                @else
                    <i class="fa fa-plus"></i>
                    <h3 class="ml-3 mb-0">Cadastrar Conta à Pagar</h3>
                @endif
            </div>
        </div>

        <div class="card-body">
            @isset($contaPagar)
                @php
                    $novoStatus = $contaPagar->getStatus() == 'Pago' ? 'Em aberto' : 'Pago';
                    $idForm     = $novoStatus == 'Pago' ? 'form-conta' : 'form-cancel';
                @endphp

                <form method="POST" id="{{ $idForm }}" action="{{ route('contas-a-pagar.update', $contaPagar->getPrimaryKeyStr()) }}">
                @method('PUT')

                <input type="hidden" name="status" value="{{ $novoStatus }}">
            @else
                <form method="POST" action="{{ route('contas-a-pagar.store') }}">
            @endisset
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

                @isset($contaPagar)
                    <div class="btn-group-lg">
                    @if ($contaPagar->getStatus() == 'Pago')
                        <button class="btn btn-danger mr-2" id="btn-cancel">
                            <span class="text-bold">Cancelar</span>
                        </button>
                    @else
                        <button class="btn btn-success mr-2" id="btn-pagar">
                            <span class="text-bold">Confirmar</span>
                        </button>
                    @endif
                        <a class="btn btn-outline-secondary" href="{{ route('contas-a-pagar.index') }}">
                            <span class="text-bold">Cancelar</span>
                        </a>
                    </div>
                @else
                    @include('contas-a-pagar.actions')
                @endisset
            </div>
        </div>
    </div>
</div>
