<div class="col-xl-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                @isset($contaReceber)
                    @if ($contaReceber->getStatus() == 'Recebido')
                        <i class="fa fa-ban"></i>
                        <h3 class="ml-3 mb-0">Cancelar Recebimento</h3>
                    @else
                        <i class="fa fa-check"></i>
                        <h3 class="ml-3 mb-0">Confirmar Recebimento</h3>
                    @endif
                @else
                    <i class="fa fa-plus"></i>
                    <h3 class="ml-3 mb-0">Cadastrar Conta à Receber</h3>
                @endif
            </div>
        </div>

        <div class="card-body">
            @isset($contaReceber)
                @php
                    $novoStatus = $contaReceber->getStatus() == 'Recebido' ? 'Em aberto' : 'Recebido';
                    $idForm     = $novoStatus == 'Recebido' ? 'form-conta' : 'form-cancel';
                @endphp

                <form method="POST" id="{{ $idForm }}" action="{{ route('contas-a-receber.update', $contaReceber->getPrimaryKeyStr()) }}">
                    @method('PUT')

                    <input type="hidden" name="status" value="{{ $novoStatus }}">
            @else
                <form method="POST" action="{{ route('contas-a-receber.store') }}">
            @endisset
                    @csrf
                    @include('contas-a-receber.fields')

                    <div class="d-flex align-items-center justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                        <div class="d-flex flex-column text-secondary">
                            <small><b>Cadastrado em: </b>{{ isset($contaReceber) ? $contaReceber->getDataCadastro() : "__/__/____" }}</small>
                            <small><b>Alterado em: </b>{{ isset($contaReceber) ? $contaReceber->getDataAlteracao() : "__/__/____" }}</small>
                        </div>

                        @isset($contaReceber)
                        <div class="btn-group-lg">
                            @if ($contaReceber->getStatus() == 'Recebido')
                            <button type="button" class="btn btn-danger mr-2" id="btn-cancel">
                                <span class="text-bold">Cancelar</span>
                            </button>
                            @else
                            <button type="button" class="btn btn-success mr-2" id="btn-receber">
                                <span class="text-bold">Confirmar</span>
                            </button>
                            @endif
                            <a class="btn btn-outline-secondary" href="{{ route('contas-a-receber.index') }}">
                                <span class="text-bold">Voltar</span>
                            </a>
                        </div>
                        @else
                        <div class="btn-group-lg">
                            <button type="submit" class="btn btn-success mr-2">
                                <span class="text-bold">Salvar</span>
                            </button>
                            <a class="btn btn-outline-secondary" href="{{ route('contas-a-receber.index') }}">
                                <span class="text-bold">Cancelar</span>
                            </a>
                        </div>
                        @endisset
                    </div>
                </form>
        </div>
    </div>
</div>
