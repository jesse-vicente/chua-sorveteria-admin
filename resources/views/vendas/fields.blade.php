<div class="form-row">
    <div class="form-group required col-xl-05">
        <label>Modelo</label>
        <input
            type="number"
            id="modelo"
            name="modelo"
            class="form-control @error('modelo') is-invalid @enderror"
            value="{{ old('modelo', isset($venda) ? $venda->getModelo() : null) }}"
        >

        @error('modelo')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-05">
        <label>Série</label>
        <input
            type="text"
            id="serie"
            name="serie"
            class="form-control @error('serie') is-invalid @enderror"
            value="{{ old('serie', isset($venda) ? $venda->getSerie() : null) }}"
        >

        @error('serie')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-05">
        <label>Número</label>
        <input
            type="number"
            id="numero"
            name="numero"
            class="form-control @error('numero') is-invalid @enderror"
            value="{{ old('numero', isset($venda) ? $venda->getNumero() : null) }}"
        >

        @error('numero')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-data">
        <label>Data de Emissão</label>
        <input
            type="date"
            id="data_emissao"
            name="data_emissao"
            class="form-control @error('data_emissao') is-invalid @enderror"
            value="{{ old('data_emissao', isset($venda) ? $venda->getDataEmissao() : null) }}"
        >

        @error('data_emissao')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('cliente_id') is-invalid @enderror"
            name="cliente_id"
            id="cliente_id"
            data-input="#cliente"
            data-route="clientes"
            value="{{ old('cliente_id', isset($venda) ? $venda->getCliente()->getId() : null) }}"
        >

        @error('cliente_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-4">
        <label>Cliente</label>
        <div class="input-group">
            <input
                class="form-control"
                name="cliente"
                id="cliente"
                value="{{ old('cliente', isset($venda) ? $venda->getCliente()->getRazaoSocial() : null) }}"
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
    </div>

    <div id="modal-clientes" class="modal fade" data-field="cliente" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Cliente</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('clientes.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('produto_id') is-invalid @enderror"
            name="produto_id"
            id="produto_id"
            data-input="#produto"
            data-route="produtos"
            value="{{ old('produto_id', isset($venda) ? $venda->getProduto()->getId() : null) }}"
            disabled
        >

        @error('produto_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-4">
        <label>Produto</label>
        <div class="input-group">
            <input
                class="form-control"
                name="produto"
                id="produto"
                value="{{ old('produto', isset($venda) ? $venda->getProduto()->getProduto() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#produto_id"
                    data-route="produtos"
                    data-toggle="modal"
                    data-target="#modal-produtos"
                    disabled
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-produtos" class="modal fade" data-field="produto" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Produto</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('produtos.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-xl-5">
        @include('vendas.products-table')
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Descontos (%)</label>

        <input
            type="number"
            id="despesas"
            name="despesas"
            placeholder="0,00"
            class="form-control @error('despesas') is-invalid @enderror"
            value="{{ old('despesas', isset($venda) ? $venda->getOutrasDespesas() : null) }}"
            disabled
        >

        @error('despesas')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-1">
        <label>Total Produtos</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="total_produtos"
                name="total_produtos"
                placeholder="0,00"
                class="form-control @error('total_produtos') is-invalid @enderror"
                value="{{ old('total_produtos', isset($venda) ? $venda->getTotalProdutos() : null) }}"
                readonly
            >

            @error('total_produtos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-1">
        <label>Total Venda</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="total_venda"
                name="total_venda"
                placeholder="0,00"
                class="form-control @error('total_venda') is-invalid @enderror"
                value="{{ old('total_venda', isset($venda) ? $venda->getTotal() : null) }}"
                readonly
            >

            @error('total_venda')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('condicao_pagamento_id') is-invalid @enderror"
            name="condicao_pagamento_id"
            id="condicao_pagamento_id"
            data-input="#condicao_pagamento"
            data-route="condicoes-pagamento"
            value="{{ old('condicao_pagamento_id', isset($venda) ? $venda->getCondicaoPagamento()->getId() : null) }}"
            disabled
        >

        @error('condicao_pagamento_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-4">
        <label>Condição de Pagamento</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                name="condicao_pagamento"
                id="condicao_pagamento"
                value="{{ old('condicao_pagamento', isset($venda) ? $venda->getCondicaoPagamento()->getCondicaoPagamento() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#condicao_pagamento_id"
                    data-route="condicoes-pagamento"
                    data-toggle="modal"
                    data-target="#modal-condicoes-pagamento"
                    disabled
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-condicoes-pagamento" class="modal fade" data-field="condicao_pagamento" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Condição de Pagamento</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('condicoes-pagamento.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-xl-5">
        @include('contas-a-receber.table')
    </div>
</div>

<div class="form-row">
    <div class="col-xl-5">
        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes', isset($venda) ? $venda->getObservacoes() : null) }}</textarea>
    </div>
</div>
