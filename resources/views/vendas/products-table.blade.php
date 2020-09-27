<table class="table table-sm table-striped table-responsive-xl table-bordered rounded" id="produtos-table">
    @isset($venda)
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th class="text-center">Und.</th>
                <th>Categoria</th>
                <th class="text-center">Qtd.</th>
                <th class="text-right">Preço</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($venda->getProdutos() as $produtoVenda)
            <tr>
                <td>{{ $produtoVenda->getProduto()->getId() }}</td>
                <td>{{ $produtoVenda->getProduto()->getProduto() }}</td>
                <td class="text-center">{{ $produtoVenda->getProduto()->getUnidade() }}</td>
                <td>{{ $produtoVenda->getProduto()->getCategoria()->getCategoria() }}</td>
                <td class="text-center">{{ $produtoVenda->getQuantidade() }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($produtoVenda->getProduto()->getPrecoCusto(), 2) }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($produtoVenda->getQuantidade() * $produtoVenda->getProduto()->getPrecoCusto(), 2) }}</td>
            </tr>
        @empty

        @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th class="text-center">Und.</th>
                <th>Categoria</th>
                <th class="text-center">Qtd.</th>
                <th class="text-right">Preço</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </tfoot>
    @endisset
</table>

<!-- <div class="card-footer bg-white">
    <strong class="d-flex justify-content-end text-success text-lg">
        <span class="mr-2 text-gray">Total à Pagar: </span>
        @isset($venda)
            {{ 'R$' . number_format($venda->getTotalVenda(), 2) }}
        @else
            {{ 'R$ 0,00' }}
        @endif
    </strong>
    <button id='remove-item' class="pull-right btn btn-danger" disabled>
        <i class="fa fa-trash-alt mr-2"></i>Remover Item
    </button>
</div> -->

<div id="modal-detalhes-produto" class="modal fade" data-field="fornecedor" role="dialog">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2 bg-dark bg-dark">
                <h3 class="modal-title">Detalhes do Produto</h3>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-2">
                        <label>Código</label>
                        <input
                            type="number"
                            id="produto_cod"
                            name="produto_cod"
                            class="form-control"
                            readonly
                            disabled
                        >
                    </div>

                    <div class="form-group col-xl-6">
                        <label>Produto</label>
                        <input
                            type="text"
                            id="descricao"
                            name="descricao"
                            class="form-control"
                            readonly
                            disabled
                        >
                    </div>

                    <div class="form-group col-xl-2">
                        <label>Unidade</label>
                        <input
                            type="text"
                            id="unidade"
                            name="unidade"
                            class="form-control"
                            readonly
                            disabled
                        >
                    </div>

                    <div class="form-group col-xl-2">
                        <label>Estoque</label>
                        <input
                            type="text"
                            id="estoque"
                            name="estoque"
                            class="form-control"
                            readonly
                            disabled
                        >
                    </div>
                </div>

                <div class="form-row">

                    <!-- <div class="form-group col-xl-4">
                        <label>Custo Últ. Venda</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>

                            <input
                                type="number"
                                id="custo_ultima_venda"
                                name="custo_ultima_venda"
                                placeholder="0,00"
                                class="form-control"
                                readonly
                                disabled
                            >
                        </div>
                    </div>

                    <div class="form-group col-xl-2">
                        <label>Estoque</label>
                        <input
                            type="number"
                            id="estoque"
                            name="estoque"
                            placeholder="0"
                            class="form-control"
                            readonly
                            disabled
                        >
                    </div> -->

                    <div class="form-group col-xl-6">
                        <label>Categoria</label>
                        <input
                            type="text"
                            id="categoria"
                            name="categoria"
                            class="form-control"
                            readonly
                            disabled
                        >
                    </div>

                    <div class="form-group col-xl-3 required">
                        <label>Quantidade</label>
                        <input
                            type="number"
                            id="quantidade"
                            name="quantidade"
                            class="form-control"
                            min="1"
                            step="1"
                            oninput="validity.valid || (value = '');"
                        >

                        <span class="invalid-feedback" role="alert">
                            <strong>Quantidade indisponível.</strong>
                        </span>
                    </div>

                    <div class="form-group col-xl-3 required">
                        <label>Preço</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text px-2">R$</span>
                            </div>

                            <input
                                type="number"
                                id="valor"
                                name="valor"
                                placeholder="0,00"
                                class="form-control"
                                readonly
                                disabled
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between" id="total">
                <strong class="text-success text-lg">
                    <span class="text-gray">Total: </span>
                    R$ 0,00
                </strong>

                <button id="add-item" class="pull-right btn btn-success" data-dismiss="modal" disabled>
                    <i class="fa fa-plus mr-2"></i>Adicionar Item
                </button>
            </div>
        </div>
    </div>
</div>
