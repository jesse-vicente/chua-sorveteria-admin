<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($condicaoPagamento) ? $condicaoPagamento->getId() : 0) }}"
            readonly
        />

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-5">
        <label>Condição de Pagamento</label>
        <input
            type="text"
            id="condicao_pagamento"
            name="condicao_pagamento"
            class="form-control @error('condicao_pagamento') is-invalid @enderror"
            value="{{ old('condicaoPagamento', isset($condicaoPagamento) ? $condicaoPagamento->getCondicaoPagamento() : null) }}"
        />

        @error('condicao_pagamento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Juros (%)</label>
        <input
            type="number"
            id="juros"
            name="juros"
            class="form-control @error('juros') is-invalid @enderror"
            value="{{ old('juros', isset($condicaoPagamento) ? $condicaoPagamento->getJuros() : null) }}"
        />

        @error('juros')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Multa (%)</label>
        <input
            type="number"
            id="multa"
            name="multa"
            class="form-control @error('multa') is-invalid @enderror"
            value="{{ old('multa', isset($condicaoPagamento) ? $condicaoPagamento->getMulta() : null) }}"
        />

        @error('multa')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Desconto (%)</label>
        <input
            type="number"
            id="desconto"
            name="desconto"
            class="form-control @error('desconto') is-invalid @enderror"
            value="{{ old('desconto', isset($condicaoPagamento) ? $condicaoPagamento->getDesconto() : null) }}"
        />

        @error('desconto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<button type="button" class="btn btn-sm btn-success add-new mb-3">
    <i class="fa fa-plus mr-1"></i>
    <span>Adicionar Parcela</span>
</button>

<div class="table-wrapper mb-4">
    <table id="parcelas-table" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="d-none">Cód. Parcela</th>
                <th class="col-form-label-sm" style="width: 7%;">Parcela</th>
                <th class="col-form-label-sm">Forma de Pagamento <span class="required">*</span></th>
                <th class="col-form-label-sm" style="width: 14%;">Prazo (dias) <span class="required">*</span></th>
                <th class="col-form-label-sm" style="width: 16%;">Percentual (%) <span class="required">*</span></th>
                <th class="col-form-label-sm text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($condicaoPagamento) && $condicaoPagamento->getTotalParcelas() > 0)
                @foreach ($condicaoPagamento->getParcelas() as $i => $parcela)
                    <tr>
                        <td class="d-none parcela_id">{{ $parcela->getId() }}</td>
                        <td>
                            <input
                                type="number"
                                class="form-control form-control-sm numero-parcela"
                                name="parcelas[]"
                                value="{{ $parcela->getNumero() }}"
                                required
                                readonly
                            >
                        </td>
                        <td>
                            <div class="form-row">
                                <div class="form-group col-xl-2 mb-0">
                                    <input
                                        type="text"
                                        placeholder="Cód."
                                        class="form-control form-control-sm"
                                        name="forma_pagamento_id[]"
                                        id="forma_pagamento_id[]"
                                        data-input="#forma_pagamento[]"
                                        data-route="formas-pagamento"
                                        value="{{ $parcela->getFormaPagamento()->getId() }}"
                                        readonly
                                        required
                                    >
                                </div>

                                <div class="form-group col-md-10 mb-0">
                                    <div class="input-group input-group-sm">

                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            name="forma_pagamento[]"
                                            id="forma_pagamento"
                                            value="{{ $parcela->getFormaPagamento()->getFormaPagamento() }}"
                                            readonly
                                            required
                                        >

                                        <div class="input-group-append">
                                            <button
                                                class="btn btn-primary btn-search"
                                                type="button"
                                                data-input="#forma_pagamento_id"
                                                data-route="formas-pagamento"
                                                data-toggle="modal"
                                                data-target="#modal-formas-pagamento"
                                            >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input
                                type="number"
                                class="form-control form-control-sm prazo"
                                name="prazo[]"
                                min="1"
                                max="180"
                                value="{{ $parcela->getPrazo() }}"
                                readonly
                                required
                            >
                        </td>
                        <td>
                            <input
                                type="number"
                                class="form-control form-control-sm porcentagem"
                                name="porcentagem[]"
                                min="0"
                                max="100"
                                value="{{ $parcela->getPorcentagem() }}"
                                readonly
                                required
                            >
                        </td>
                        <td class="pt-2 actions text-center">
                            <button
                                type="button"
                                class="btn btn-xs mx-1 btn-success add"
                                title="Adicionar"
                                style="display: none;"
                            >
                                <i class="fa fa-check"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-xs mx-1 btn-warning edit"
                                title="Editar"
                            >
                                <i class="fa fa-edit text-white"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-xs mx-1 btn-danger delete"
                                title="Remover"
                            >
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
            @endif
        </tbody>
    </table>
</div>

<div id="modal-formas-pagamento" class="modal fade" data-field="forma_pagamento[]" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2 bg-dark">
                <h3 class="modal-title">Buscar Forma de Pagamento</h3>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @include('formas-pagamento.search')
            </div>
        </div>
    </div>
</div>

<input
    type="hidden"
    id="total_parcelas"
    name="total_parcelas"
    value="{{ old('total_parcelas', isset($condicaoPagamento) ? $condicaoPagamento->getTotalParcelas() : null) }}"
    readonly
/>
