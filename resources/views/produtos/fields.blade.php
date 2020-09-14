<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="text"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($produto) ? $produto->getId() : null) }}"
            readonly
        >

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-8">
        <label>Produto</label>
        <input
            type="text"
            id="produto"
            name="produto"
            class="form-control @error('produto') is-invalid @enderror"
            value="{{ old('produto', isset($produto) ? $produto->getProduto() : null) }}"
        >

        @error('produto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Unidade</label>
        <input
            type="text"
            id="unidade"
            name="unidade"
            class="form-control @error('unidade') is-invalid @enderror"
            value="{{ old('unidade', isset($produto) ? $produto->getUnidade() : null) }}"
        >

        @error('unidade')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('fornecedor_id') is-invalid @enderror"
            name="fornecedor_id"
            id="fornecedor_id"
            data-input="#fornecedor"
            data-route="fornecedores"
            value="{{ old('fornecedor_id', isset($produto) ? $produto->getFornecedor()->getId() : null) }}"
        >

        @error('fornecedor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-10">
        <label>Fornecedor</label>
        <div class="input-group">
            <input
                class="form-control"
                name="fornecedor"
                id="fornecedor"
                value="{{ old('fornecedor', isset($produto) ? $produto->getFornecedor()->getRazaoSocial() : null) }}"
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
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('categoria_id') is-invalid @enderror"
            name="categoria_id"
            id="categoria_id"
            data-input="#categoria"
            data-route="categorias"
            value="{{ old('categoria_id', isset($produto) ? $produto->getCategoria()->getId() : null) }}"
        >

        @error('categoria_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-10">
        <label>Categoria</label>
        <div class="input-group">
            <input
                class="form-control"
                name="categoria"
                id="categoria"
                value="{{ old('categoria', isset($produto) ? $produto->getCategoria()->getCategoria() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#categoria_id"
                    data-route="categorias"
                    data-toggle="modal"
                    data-target="#modal-categorias"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-categorias" class="modal fade" data-field="categoria" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Categoria</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('categorias.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-3">
        <label>Estoque Atual</label>
        <input
            type="number"
            id="estoque"
            name="estoque"
            class="form-control @error('estoque') is-invalid @enderror"
            value="{{ old('estoque', isset($produto) ? $produto->getEstoque() : null) }}"
            readonly
        >

        @error('estoque')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group col-xl-3">
        <label>Preço Custo</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="preco_custo"
                name="preco_custo"
                class="form-control @error('preco_custo') is-invalid @enderror"
                value="{{ old('preco_custo', isset($produto) ? $produto->getPrecoCusto() : null) }}"
                readonly
            >

            @error('preco_custo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Preço Venda</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="preco_venda"
                name="preco_venda"
                class="form-control @error('preco_venda') is-invalid @enderror"
                value="{{ old('preco_venda', isset($produto) ? $produto->getPrecoVenda() : null) }}"
            >

            @error('preco_venda')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-3">
        <label style="font-size: 0.95rem;">Custo Últ. Compra</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="custo_ultima_compra"
                name="custo_ultima_compra"
                class="form-control @error('custo_ultima_compra') is-invalid @enderror"
                value="{{ old('custo_ultima_compra', isset($produto) ? $produto->getCustoUltimaCompra() : null) }}"
                readonly
            >

            @error('custo_ultima_compra')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-4">
        <label>Data Últ. Compra</label>
        <input
            type="date"
            id="data_ultima_compra"
            name="data_ultima_compra"
            class="form-control @error('data_ultima_compra') is-invalid @enderror"
            value="{{ old('data_ultima_compra', isset($produto) ? $produto->getDataUltimaCompra() : null) }}"
            readonly
        >

        @error('data_ultima_compra')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-4">
        <label>Data Últ. Venda</label>
        <input
            type="date"
            id="data_ultima_venda"
            name="data_ultima_venda"
            class="form-control @error('data_ultima_venda') is-invalid @enderror"
            value="{{ old('data_ultima_venda', isset($produto) ? $produto->getDataUltimaVenda() : null) }}"
            readonly
        >

        @error('data_ultima_venda')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
