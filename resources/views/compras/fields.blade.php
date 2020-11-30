@isset($compra)
    <input type="hidden" name="senha" id="senha">
@else
    <input type="hidden" name="limite_credito" id="limite_credito">
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
            value="{{ old('modelo', isset($compra) ? $compra->getModelo() : 55) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="modelo"></span>
    </div>

    <div class="form-group required col-xl-2">
        <label>Série</label>
        <input
            type="number"
            id="serie"
            name="serie"
            max="999"
            oninput="validity.valid || (value = '');"
            class="form-control @error('serie') is-invalid @enderror"
            value="{{ old('serie', isset($compra) ? $compra->getSerie() : 1) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="serie"></span>
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
            value="{{ old('num_nota', isset($compra) ? $compra->getNumeroNota() : null) }}"
            autofocus
            required
        >

        <span class="invalid-feedback" role="alert" ref="num_nota"></span>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Emissão</label>
        <input
            type="date"
            id="data_emissao"
            name="data_emissao"
            class="form-control @error('data_emissao') is-invalid @enderror"
            value="{{ old('data_emissao', isset($compra) ? $compra->getDataEmissao() : date('Y-m-d')) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="data_emissao"></span>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Chegada</label>
        <input
            type="date"
            id="data_chegada"
            name="data_chegada"
            class="form-control @error('data_chegada') is-invalid @enderror"
            value="{{ old('data_chegada', isset($compra) ? $compra->getDataChegada() : date('Y-m-d')) }}"
            required
        >

        <span class="invalid-feedback" role="alert" ref="data_chegada"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('fornecedor_id') is-invalid @enderror"
            name="fornecedor_id"
            id="ipt_fornecedor_id"
            data-input="#fornecedor"
            data-route="fornecedores"
            value="{{ old('fornecedor_id', isset($compra) ? $compra->getFornecedor()->getId() : null) }}"
            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
            required
        >

        <span class="invalid-feedback" role="alert" ref="fornecedor_id"></span>
    </div>

    <div class="form-group required col-xl-10" id="ipt-fornecedor">
        <label>Fornecedor</label>
        <div class="input-group">
            <input
                class="form-control"
                name="fornecedor"
                id="fornecedor"
                value="{{ old('fornecedor', isset($compra) ? $compra->getFornecedor()->getRazaoSocial() : null) }}"
                readonly
                required
                data-error="#ipt-fornecedor"
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Fornecedor</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('fornecedores.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex mt-4">
    <hr class="flex-grow-1">
    <div class="px-4">
        <h4 class="text-gray">
            <i class="fa fa-shopping-cart mr-1"></i>
            Produtos
        </h4>
    </div>
    <hr class="flex-grow-1">
</div>

@empty($compra)
<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('produto_id') is-invalid @enderror"
            name="produto_id"
            id="ipt_produto_id"
            data-input="#produto"
            data-route="produtos"
            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
            readonly
        >
    </div>

    <div class="form-group required col-xl-10">
        <label>Produto</label>
        <div class="input-group">
            <input
                class="form-control @error('produto') is-invalid @enderror"
                name="produto"
                id="produto"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#ipt_produto_id"
                    data-route="produtos"
                    data-toggle="modal"
                    data-target="#modal-produtos"
                    disabled
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <span class="invalid-feedback" role="alert" ref="total_compra"></span>
    </div>

    <div id="modal-produtos" class="modal fade" data-field="produto" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Produto</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('produtos.search-compra')
                </div>
            </div>
        </div>
    </div>
</div>
@endempty

@include('compras.products-table')

<div class="form-row mt-2">
    <div class="form-group col-xl-3">
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
                value="{{ old('frete', isset($compra) ? number_format($compra->getFrete(), 2) : null) }}"
                step=".01"
                oninput="validity.valid || (value = '');"
                readonly
            >

            @error('frete')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
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
                value="{{ old('seguro', isset($compra) ? number_format($compra->getSeguro(), 2) : null) }}"
                step=".01"
                oninput="validity.valid || (value = '');"
                readonly
            >

            @error('seguro')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
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
                value="{{ old('despesas', isset($compra) ? number_format($compra->getDespesas(), 2) : null) }}"
                oninput="validity.valid || (value = '');"
                readonly
            >

            @error('despesas')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
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
                value="{{ old('total_produtos', isset($compra) ? number_format($compra->getTotalProdutos(), 2) : null) }}"
                readonly
            >

            <span class="invalid-feedback" role="alert" ref="total_produtos"></span>
        </div>
    </div>

    <div class="form-group col-xl-2 d-none">
        <label>Total da Compra</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="total_pagar"
                name="total_compra"
                placeholder="0,00"
                class="form-control @error('total_compra') is-invalid @enderror"
                value="{{ old('total_compra', isset($compra) ? number_format($compra->getTotalCompra(), 2) : null) }}"
                readonly
            >

            @error('total_compra')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

<div class="d-flex mt-4">
    <hr class="flex-grow-1">
    <div class="px-4">
        <h4 class="text-gray">
            <i class="fa fa-file-invoice-dollar mr-1"></i>
            Contas a Pagar
        </h4>
    </div>
    <hr class="flex-grow-1">
</div>

<div class="form-row mt-2">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('condicao_pagamento_id') is-invalid @enderror"
            name="condicao_pagamento_id"
            id="condicao_pagamento_id"
            data-input="#condicao_pagamento"
            data-route="condicoes-pagamento"
            value="{{ old('condicao_pagamento_id', isset($compra) ? $compra->getCondicaoPagamento()->getId() : null) }}"
            min="1"
            step="1"
            oninput="validity.valid || (value = '');"
            readonly
            required
        >

        <span class="invalid-feedback" role="alert" ref="condicao_pagamento_id"></span>
    </div>

    <div class="form-group required col-xl-10" id="ipt-condicao-pagamento">
        <label>Condição de Pagamento</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                name="condicao_pagamento"
                id="condicao_pagamento"
                value="{{ old('condicao_pagamento', isset($compra) ? $compra->getCondicaoPagamento()->getCondicaoPagamento() : null) }}"
                readonly
                required
                data-error="#ipt-condicao-pagamento"
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Condição de Pagamento</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('condicoes-pagamento.search')
                </div>
            </div>
        </div>
    </div>
</div>

@include('compras.duplicatas-table')

<div class="form-row mt-4">
    <div class="col-xl-12">
        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes', isset($compra) ? $compra->getObservacoes() : null) }}</textarea>
    </div>
</div>
