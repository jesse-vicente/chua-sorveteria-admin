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
                    <h3 class="ml-3 mb-0">Cadastrar Conta a Pagar</h3>
                @endif
            </div>
        </div>

        <div class="card-body">
            @isset($contaPagar)
                @php
                    if ($contaPagar->getCompra())
                        $novoStatus = $contaPagar->getStatus() == 'Pago' ? 'Em aberto' : 'Pago';
                    else
                        $novoStatus = $contaPagar->getStatus() == 'Pago' ? 'Cancelado' : 'Pago';

                    $idForm = $novoStatus == 'Pago' ? 'form-conta' : 'form-cancel';
                @endphp

                <form method="POST" id="{{ $idForm }}" action="{{ route('contas-a-pagar.update', $contaPagar->getPrimaryKeyStr()) }}">
                    @method('PUT')

                    <input type="hidden" name="status" value="{{ $novoStatus }}">
            @else
                <form method="POST" action="{{ route('contas-a-pagar.store') }}">
            @endisset
                    @csrf
                    @include('contas-a-pagar.fields')

                    <div class="d-flex align-items-center justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                        <div class="d-flex flex-column text-secondary">
                            <small><b>Cadastrado em: </b>{{ isset($contaPagar) ? $contaPagar->getDataCadastro() : "__/__/____" }}</small>
                            <small><b>Alterado em: </b>{{ isset($contaPagar) ? $contaPagar->getDataAlteracao() : "__/__/____" }}</small>
                        </div>

                        @isset($contaPagar)
                        <div class="btn-group-lg">
                            @if ($contaPagar->getStatus() == 'Pago')
                            <button type="button" class="btn btn-danger mr-2" id="btn-cancel">
                                <span class="text-bold">Cancelar Pagamento</span>
                            </button>
                            @else
                            <button type="button" class="btn btn-success mr-2" id="btn-pagar">
                                <span class="text-bold">Confirmar Pagamento</span>
                            </button>
                            @endif
                            <a class="btn btn-outline-secondary" href="{{ route('contas-a-pagar.index') }}">
                                <span class="text-bold">Voltar</span>
                            </a>
                        </div>
                        @else
                        <div class="btn-group-lg">
                            <button type="submit" class="btn btn-success mr-2">
                                <span class="text-bold">Salvar</span>
                            </button>
                            <a class="btn btn-outline-secondary" href="{{ route('contas-a-pagar.index') }}">
                                <span class="text-bold">Voltar</span>
                            </a>
                        </div>
                        @endisset
                    </div>
                </form>
        </div>
    </div>
</div>

@include('fornecedores.create-modal')
@include('formas-pagamento.create-modal')
