<div class="alert alert-danger pb-0" id="form-errors" style="display: none;">
    <ul class="list-unstyled"></ul>
</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Modelo</label>
        <input
            type="number"
            id="modelo"
            name="modelo"
            class="form-control @error('modelo') is-invalid @enderror"
            value="{{ old('modelo', isset($venda) ? $venda->getModelo() : 55) }}"
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
            class="form-control @error('serie') is-invalid @enderror"
            value="{{ old('serie', isset($venda) ? $venda->getSerie() : 1) }}"
        >

        <span class="invalid-feedback" role="alert" ref="serie"></span>
    </div>

    <div class="form-group required col-xl-2">
        <label>Número</label>
        <input
            type="number"
            id="num_nota"
            name="num_nota"
            class="form-control @error('num_nota') is-invalid @enderror"
            value="{{ old('num_nota', isset($venda) ? $venda->getNumeroNota() : 0) }}"
            disabled
        >

        <span class="invalid-feedback" role="alert" ref="num_nota"></span>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data</label>
        <input
            type="date"
            id="data_venda"
            name="data_venda"
            class="form-control @error('data_venda') is-invalid @enderror"
            value="{{ old('data_venda', isset($venda) ? $venda->getDataVenda() : date('Y-m-d')) }}"
        >

        <span class="invalid-feedback" role="alert" ref="data_venda"></span>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('fornecedor_id') is-invalid @enderror"
            name="cliente_id"
            id="cliente_id"
            data-input="#cliente"
            data-route="clientes"
            @isset($venda)
                value="{{ old('cliente_id', $venda->getCliente() ? $venda->getCliente()->getId() : null) }}"
            @endisset
        >

        <span class="invalid-feedback" role="alert" ref="cliente_id"></span>
    </div>

    <div class="form-group col-xl-10">
        <label>Cliente</label>
        <div class="input-group">
            <input
                class="form-control"
                name="cliente"
                id="cliente"
                @isset($venda)
                    value="{{ old('cliente', $venda->getCliente() ? $venda->getCliente()->getNome() : null) }}"
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

@empty($venda)
<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('produto_id') is-invalid @enderror"
            name="produto_id"
            id="produto_id"
            data-input="#produto"
            data-route="produtos"
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
                    data-input="#produto_id"
                    data-route="produtos"
                    data-toggle="modal"
                    data-target="#modal-produtos"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <span class="invalid-feedback" role="alert" ref="total_venda"></span>
    </div>

    <div id="modal-produtos" class="modal fade" data-field="produto" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Produto</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('produtos.search-venda')
                </div>
            </div>
        </div>
    </div>
</div>
@endempty

@include('vendas.products-table')

<div class="form-row mt-2">
    <div class="form-group col-xl-2">
        <label>Descontos</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="descontos"
                name="descontos"
                placeholder="0,00"
                class="form-control @error('descontos') is-invalid @enderror"
                value="{{ old('descontos', isset($venda) ? number_format($venda->getDescontos(), 2) : null) }}"
                step=".01"
                oninput="validity.valid || (value = '');"
                readonly
            >

            @error('descontos')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-2">
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
                value="{{ old('total_produtos', isset($venda) ? number_format($venda->getTotalProdutos(), 2) : null) }}"
                readonly
            >

            <span class="invalid-feedback" role="alert" ref="total_produtos"></span>
        </div>
    </div>

    <div class="form-group col-xl-2">
        <label>Total da Venda</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="total_pagar"
                name="total_venda"
                placeholder="0,00"
                class="form-control @error('total_venda') is-invalid @enderror"
                value="{{ old('total_venda', isset($venda) ? number_format($venda->getTotalVenda(), 2) : null) }}"
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

<div class="form-row mt-4">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('condicao_pagamento_id') is-invalid @enderror"
            name="condicao_pagamento_id"
            id="condicao_pagamento_id"
            data-input="#condicao_pagamento"
            data-route="condicoes-pagamento"
            value="{{ old('condicao_pagamento_id', isset($venda) ? $venda->getCondicaoPagamento()->getId() : null) }}"
            readonly
        >

        <span class="invalid-feedback" role="alert" ref="condicao_pagamento_id"></span>
    </div>

    <div class="form-group required col-xl-10">
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

@include('vendas.duplicatas-table')

<div class="form-row mt-4">
    <div class="col-xl-12">
        <label for="observacoes">Observações</label>
        <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes', isset($venda) ? $venda->getObservacoes() : null) }}</textarea>
    </div>
</div>
