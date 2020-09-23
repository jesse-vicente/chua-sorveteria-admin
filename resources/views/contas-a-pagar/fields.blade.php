<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Modelo</label>
        <input
            type="number"
            id="modelo"
            name="modelo"
            class="form-control @error('modelo') is-invalid @enderror"
            value="{{ old('modelo', isset($contaPagar) ? $contaPagar->getCompra()->getModelo() : 55) }}"
        >

        <span class="invalid-feedback" role="alert" ref="modelo"></span>
    </div>

    <div class="form-group required col-xl-2">
        <label>Série</label>
        <input
            type="text"
            id="serie"
            name="serie"
            class="form-control @error('serie') is-invalid @enderror"
            value="{{ old('serie', isset($contaPagar) ? $contaPagar->getCompra()->getSerie() : 1) }}"
        >

    </div>

    <div class="form-group required col-xl-2">
        <label>Número</label>
        <input
            type="number"
            id="num_nota"
            name="num_nota"
            class="form-control @error('num_nota') is-invalid @enderror"
            value="{{ old('num_nota', isset($contaPagar) ? $contaPagar->getCompra()->getNumeroNota() : null) }}"
        >

    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Emissão</label>
        <input
            type="date"
            id="data_emissao"
            name="data_emissao"
            class="form-control @error('data_emissao') is-invalid @enderror"
            value="{{ old('data_emissao', isset($contaPagar) ? $contaPagar->getCompra()->getDataEmissao() : date('Y-m-d')) }}"
        >

    </div>

</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('fornecedor_id') is-invalid @enderror"
            name="fornecedor_id"
            id="fornecedor_id"
            data-input="#fornecedor"
            data-route="fornecedores"
            value="{{ old('fornecedor_id', isset($contaPagar) ? $contaPagar->getFornecedor()->getId() : null) }}"
        >

        @error('fornecedor_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-9">
        <label>Fornecedor</label>
        <div class="input-group">
            <input
                class="form-control"
                name="fornecedor"
                id="fornecedor"
                value="{{ old('fornecedor', isset($contaPagar) ? $contaPagar->getFornecedor()->getRazaoSocial() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#fornecedor_id"
                    data-route="fornecedores"
                    data-toggle="modal"
                    data-target="#modal-fornecedores"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <span class="invalid-feedback" role="alert" ref="fornecedor"></span>
    </div>

    <div id="modal-fornecedores" class="modal fade" data-field="fornecedor" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Fornecedor</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('fornecedores.search')
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
            value="{{ old('forma_pagamento_id', isset($contaPagar) ? $contaPagar->getFormaPagamento()->getId() : null) }}"
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
                value="{{ old('forma_pagamento', isset($contaPagar) ? $contaPagar->getFormaPagamento()->getFormaPagamento() : null) }}"
                readonly
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Forma de Pagamento</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
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
            value="{{ old('parcela', isset($contaPagar) ? $contaPagar->getParcela() : null) }}"
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
                value="{{ old('valor_parcela', isset($contaPagar) ? number_format($contaPagar->getValorParcela(), 2) : null) }}"
            >

            @error('valor_parcela')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data Vencimento</label>
        <input
            type="date"
            id="data_vencimento"
            name="data_vencimento"
            class="form-control @error('data_vencimento') is-invalid @enderror"
            value="{{ old('data_vencimento', isset($contaPagar) ? $contaPagar->getDataVencimento() : date('Y-m-d')) }}"
        >

        @error('data_vencimento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-3">
        <label>Data Pagamento</label>
        <input
            type="date"
            id="data_pagamento"
            name="data_pagamento"
            class="form-control @error('data_pagamento') is-invalid @enderror"
            value="{{ old('data_pagamento', isset($contaPagar) ? $contaPagar->getDataPagamento() : date('Y-m-d')) }}"
        >

        @error('data_pagamento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Juros</label>

        <div class="input-group">
            <input
                type="number"
                id="juros"
                name="juros"
                placeholder="0"
                class="form-control @error('juros') is-invalid @enderror"
                @isset($contaPagar)
                    value="{{ old('juros', $contaPagar->getJuros() ? number_format($contaPagar->getJuros(), 2) : null) }}"
                @endisset
            >

            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>

            @error('juros')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
        <label>Multa</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="multa"
                name="multa"
                placeholder="0,00"
                class="form-control @error('multa') is-invalid @enderror"
                @isset($contaPagar)
                    value="{{ old('multa', $contaPagar->getMulta() ? number_format($contaPagar->getMulta(), 2) : null) }}"
                @endisset
            >

            @error('multa')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
        <label>Desconto</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="desconto"
                name="desconto"
                placeholder="0,00"
                class="form-control @error('desconto') is-invalid @enderror"
                @isset($contaPagar)
                    value="{{ old('desconto', $contaPagar->getDesconto() ? number_format($contaPagar->getDesconto(), 2) : null) }}"
                @endisset
            >

            @error('desconto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Valor Pago</label>

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
                @isset($contaPagar)
                    @if ($contaPagar->getStatus() == 'Pendente')
                        value="{{ number_format($contaPagar->getValorParcela(), 2) }}"
                    @elseif ($contaPagar->getStatus() == 'Liquidado')
                        value="{{ old('valor_pago', number_format($contaPagar->getValorPago(), 2)) }}"
                    @endif
                @endisset
            >

            @error('valor_pago')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>
