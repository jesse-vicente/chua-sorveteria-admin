@isset($contaReceber)
    <input type="hidden" name="senha" id="senha">
@endisset

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Modelo</label>
        <input
            type="number"
            id="modelo"
            name="modelo"
            max="99"
            oninput="validity.valid || (value = '');"
            class="form-control @error('modelo') is-invalid @enderror"
            value="{{ old('modelo', isset($contaReceber) ? $contaReceber->getVenda()->getModelo() : 55) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="modelo"></span>
    </div>

    <div class="form-group required col-xl-2">
        <label>Série</label>
        <input
            type="text"
            id="serie"
            name="serie"
            max="999"
            oninput="validity.valid || (value = '');"
            class="form-control @error('serie') is-invalid @enderror"
            value="{{ old('serie', isset($contaReceber) ? $contaReceber->getVenda()->getSerie() : 1) }}"
            required
        >

    </div>

    <div class="form-group required col-xl-2">
        <label>Número</label>
        <input
            type="number"
            id="num_nota"
            name="num_nota"
            max="999999"
            oninput="validity.valid || (value = '');"
            class="form-control @error('num_nota') is-invalid @enderror"
            value="{{ old('num_nota', isset($contaReceber) ? $contaReceber->getVenda()->getNumeroNota() : null) }}"
            required
        >

    </div>

    <div class="form-group required col-xl-3">
        <label>Data da Venda</label>
        <input
            type="date"
            id="data_venda"
            name="data_venda"
            class="form-control @error('data_venda') is-invalid @enderror"
            value="{{ old('data_venda', isset($contaReceber) ? $contaReceber->getVenda()->getDataVenda() : date('Y-m-d')) }}"
            required
        >

    </div>

</div>

<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('cliente_id') is-invalid @enderror"
            name="cliente_id"
            id="cliente_id"
            data-input="#cliente"
            data-route="clientes"
            @isset($contaReceber)
                value="{{ old('cliente_id', $contaReceber->getCliente() ? $contaReceber->getCliente()->getId() : null) }}"
            @endisset

            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
        >

        @error('cliente_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group col-xl-9">
        <label>Cliente</label>
        <div class="input-group">
            <input
                class="form-control"
                name="cliente"
                id="cliente"
                @isset($contaReceber)
                    value="{{ old('cliente', $contaReceber->getCliente() ? $contaReceber->getCliente()->getNome() : null) }}"
                @endisset
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#cliente_id"
                    data-route="clientes"
                    data-toggle="modal"
                    data-target="#modal-clientes"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <span class="invalid-feedback" role="alert" ref="cliente"></span>
    </div>

    <div id="modal-clientes" class="modal fade" data-field="cliente" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Cliente</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('clientes.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row mt-4">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('forma_pagamento_id') is-invalid @enderror"
            name="forma_pagamento_id"
            id="forma_pagamento_id"
            data-input="#forma_pagamento"
            data-route="formas-pagamento"
            value="{{ old('forma_pagamento_id', isset($contaReceber) ? $contaReceber->getFormaPagamento()->getId() : null) }}"
            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
            required
        >

        @error('forma_pagamento_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-9">
        <label>Forma de Pagamento</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                name="forma_pagamento"
                id="forma_pagamento"
                value="{{ old('forma_pagamento', isset($contaReceber) ? $contaReceber->getFormaPagamento()->getFormaPagamento() : null) }}"
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

    <div id="modal-formas-pagamento" class="modal fade" data-field="forma_pagamento" role="dialog">
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
</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Parcela</label>
        <input
            type="number"
            id="parcela"
            name="parcela"
            class="form-control @error('parcela') is-invalid @enderror"
            value="{{ old('parcela', isset($contaReceber) ? $contaReceber->getParcela() : null) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="parcela"></span>
    </div>

    <div class="form-group required col-xl-3">
        <label>Valor Parcela</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="valor_parcela"
                name="valor_parcela"
                placeholder="0,00"
                class="form-control @error('valor_parcela') is-invalid @enderror"
                value="{{ old('valor_parcela', isset($contaReceber) ? number_format($contaReceber->getValorParcela(), 2) : null) }}"
                required
            >

            @error('valor_parcela')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Vencimento</label>
        <input
            type="date"
            id="data_vencimento"
            name="data_vencimento"
            class="form-control @error('data_vencimento') is-invalid @enderror"
            value="{{ old('data_vencimento', isset($contaReceber) ? $contaReceber->getDataVencimento() : date('Y-m-d')) }}"

            @isset($contaReceber)
                value="{{ old('data_emissao', $contaReceber->getDataVencimento()) }}"
                min="{{ $contaReceber->getVenda()->getDataVenda() }}"
            @else
                value="{{ old('data_emissao', null) }}"
                min="{{ date('Y-m-d') }}"
            @endisset

            required
        >

        @error('data_vencimento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Recebimento</label>
        <input
            type="date"
            id="data_pagamento"
            name="data_pagamento"
            class="form-control @error('data_pagamento') is-invalid @enderror"
            value="{{ old('data_pagamento', isset($contaReceber) ? $contaReceber->getDataPagamento() : date('Y-m-d')) }}"
        >

        @error('data_pagamento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-3 float-right">
        <label>Total</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="valor_pago"
                name="valor_pago"
                placeholder="0,00"
                class="form-control @error('valor_pago') is-invalid @enderror"
                readonly
                value="{{ number_format($contaReceber->getValorParcela(), 2) }}"
                required
            >

            @error('valor_pago')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
