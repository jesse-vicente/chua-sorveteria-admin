<div class="form-row">
    <div class="form-group required col-xl-05">
        <label>Modelo</label>
        <input
            type="number"
            id="modelo"
            name="modelo"
            class="form-control @error('modelo') is-invalid @enderror"
            value="{{ old('modelo', isset($compra) ? $compra->getModelo() : null) }}"
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
            value="{{ old('serie', isset($compra) ? $compra->getSerie() : null) }}"
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
            value="{{ old('numero', isset($compra) ? $compra->getNumero() : null) }}"
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
            value="{{ old('data_emissao', isset($compra) ? $compra->getDataEmissao() : null) }}"
        >

        @error('data_emissao')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-data">
        <label>Data de Chegada</label>
        <input
            type="date"
            id="data_chegada"
            name="data_chegada"
            class="form-control @error('data_chegada') is-invalid @enderror"
            value="{{ old('data_chegada', isset($compra) ? $compra->getDataChegada() : null) }}"
        >

        @error('data_chegada')
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
            class="form-control @error('fornecedor_id') is-invalid @enderror"
            name="fornecedor_id"
            id="fornecedor_id"
            data-input="#fornecedor"
            data-route="fornecedores"
            value="{{ old('fornecedor_id', isset($compra) ? $compra->getFornecedor()->getId() : null) }}"
        >

        @error('fornecedor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-4">
        <label>Fornecedor</label>
        <div class="input-group">
            <input
                class="form-control"
                name="fornecedor"
                id="fornecedor"
                value="{{ old('fornecedor', isset($compra) ? $compra->getFornecedor()->getRazaoSocial() : null) }}"
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
            value="{{ old('produto_id', isset($compra) ? $compra->getProduto()->getId() : null) }}"
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
                value="{{ old('produto', isset($compra) ? $compra->getProduto()->getProduto() : null) }}"
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
        @include('compras.products-table')
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Frete</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="frete"
                name="frete"
                placeholder="0,00"
                class="form-control @error('frete') is-invalid @enderror"
                value="{{ old('frete', isset($compra) ? $compra->getFrete() : null) }}"
                disabled
            >

            @error('frete')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-1">
        <label>Seguro</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="seguro"
                name="seguro"
                placeholder="0,00"
                class="form-control @error('seguro') is-invalid @enderror"
                value="{{ old('seguro', isset($compra) ? $compra->getSeguro() : null) }}"
                disabled
            >

            @error('seguro')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-1">
        <label>Despesas</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="despesas"
                name="despesas"
                placeholder="0,00"
                class="form-control @error('despesas') is-invalid @enderror"
                value="{{ old('despesas', isset($compra) ? $compra->getOutrasDespesas() : null) }}"
                disabled
            >

            @error('despesas')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
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
                value="{{ old('total_produtos', isset($compra) ? $compra->getTotalProdutos() : null) }}"
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
        <label>Total à Pagar</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="total_pagar"
                name="total_pagar"
                placeholder="0,00"
                class="form-control @error('total_pagar') is-invalid @enderror"
                value="{{ old('total_pagar', isset($compra) ? $compra->getTotalPagar() : null) }}"
                readonly
            >

            @error('total_pagar')
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
            value="{{ old('condicao_pagamento_id', isset($compra) ? $compra->getCondicaoPagamento()->getId() : null) }}"
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
                value="{{ old('condicao_pagamento', isset($compra) ? $compra->getCondicaoPagamento()->getCondicaoPagamento() : null) }}"
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
        @include('contas-a-pagar.table')
    </div>
</div>

<div class="form-row">
    <div class="col-xl-5">
        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes', isset($compra) ? $compra->getObservacoes() : null) }}</textarea>
    </div>
</div>
