@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header bg-danger">
        <div class="d-flex align-items-center">
            <i class="fa fa-trash-alt"></i>
            <h3 class="ml-3 mb-0">Excluir Condição de Pagamento</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($condicaoPagamento)
        <form method="POST" action="{{ route('condicoes-pagamento.destroy', $condicaoPagamento->getId()) }}" id="form-delete">
            @method('DELETE')

            @csrf
            <div class="form-row">
                <div class="form-group col-xl-1">
                    <label>Código</label>
                    <input
                        type="text"
                        id="id"
                        name="id"
                        class="form-control @error('id') is-invalid @enderror"
                        value="{{ $condicaoPagamento->getId() }}"
                        readonly
                    />
                </div>

                <div class="form-group col-xl-4">
                    <label>Condição de Pagamento</label>
                    <input
                        type="text"
                        id="condicao_pagamento"
                        name="condicao_pagamento"
                        class="form-control @error('condicao_pagamento') is-invalid @enderror"
                        value="{{ $condicaoPagamento->getCondicaoPagamento() }}"
                        readonly
                    />
                </div>

                <div class="form-group col-xl-2">
                    <label>Multa</label>
                    <input
                        type="number"
                        id="multa"
                        name="multa"
                        class="form-control @error('multa') is-invalid @enderror"
                        value="{{ $condicaoPagamento->getMulta() }}"
                        readonly
                    />
                </div>

                <div class="form-group col-xl-2">
                    <label>Desconto</label>
                    <input
                        type="number"
                        id="desconto"
                        name="desconto"
                        class="form-control @error('desconto') is-invalid @enderror"
                        value="{{ $condicaoPagamento->getDesconto() }}"
                        readonly
                    />
                </div>
            </div>

            @if ($condicaoPagamento->getTotalParcelas() > 0)
            <div class="table-wrapper table-responsive">
                <label>Parcelas</label>
                <table id="parcelas-table" class="table table-bordered table-sm border-0">
                    <thead>
                        <tr>
                            <th class="col-form-label-sm">Parcela</th>
                            <th class="col-form-label-sm">Forma de Pagamento</th>
                            <th class="col-form-label-sm">Prazo</th>
                            <th class="col-form-label-sm">Juros</th>
                            <th class="col-form-label-sm">Percentual</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($condicaoPagamento->getParcelas() as $parcela)
                            <tr>
                                <td>{{ $parcela->getNumero() }}</td>
                                <td>{{ $parcela->getFormaPagamento()->getFormaPagamento() }}</td>
                                <td>{{ $parcela->getPrazo() }} dias</td>
                                <td>{{ $condicaoPagamento->getJuros() }}%</td>
                                <td>{{ $parcela->getPorcentagem() }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </form>

        @else
        <span>Registro não encontrado.</span>
        @endif
    </div>
</div>

<div class="btn-group-lg">
    <button type="button" class="btn btn-danger mr-2" id="delete-entry">
        <span class="text-bold">Excluir</span>
    </button>

    <a class="btn btn-outline-secondary" href="{{ route('condicoes-pagamento.index') }}">
        <span class="text-bold">Cancelar</span>
    </a>
</div>
@endsection
