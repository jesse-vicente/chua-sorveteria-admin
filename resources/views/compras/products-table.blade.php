<div class="card @isset($compra) mt-2 @endisset">
    <div class="card-body p-0">
        <table class="table table-sm table-striped table-responsive-xl table-borderless w-100" id="produtos-table">
        @isset($compra)
            <thead>
                <tr>
                    <th>Cód.</th>
                    <th>Produto</th>
                    <th class="text-center">Und.</th>
                    <th>Categoria</th>
                    <th class="text-center">Qtd.</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Valor Total</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($compra->getProdutos() as $produtoCompra)
                <tr>
                    <td>{{ $produtoCompra->getProduto()->getId() }}</td>
                    <td>{{ $produtoCompra->getProduto()->getProduto() }}</td>
                    <td class="text-center">{{ $produtoCompra->getProduto()->getUnidade() }}</td>
                    <td>{{ $produtoCompra->getProduto()->getCategoria()->getCategoria() }}</td>
                    <td class="text-center">{{ $produtoCompra->getQuantidade() }}</td>
                    <td class="text-right">{{ 'R$ ' . number_format($produtoCompra->getProduto()->getPrecoCusto(), 2, ',', '.') }}</td>
                    <td class="text-right">{{ 'R$ ' . number_format($produtoCompra->getQuantidade() * $produtoCompra->getProduto()->getPrecoCusto(), 2, ',', '.') }}</td>
                </tr>
            @empty

            @endforelse
            </tbody>

            <!-- <tfoot>
                <tr>
                    <th>Cód.</th>
                    <th>Produto</th>
                    <th class="text-center">Und.</th>
                    <th>Categoria</th>
                    <th class="text-center">Qtd.</th>
                    <th class="text-right">Valor</th>
                    <th class="text-right">Valor Total</th>
                </tr>
            </tfoot> -->
        @endisset
        </table>
    </div>

    @isset($compra)
    <div class="card-footer d-flex align-items-center justify-content-end">
        <strong class="text-success text-lg">
            <span class="mr-2 text-gray">Total da Compra:</span>R$ {{ number_format($compra->getTotalCompra(), 2, ',', '.') }}
        </strong>
    </div>
    @else
    <div class="card-footer d-flex align-items-center justify-content-between">
        <button id="remove-items" class="btn btn-danger" disabled>
            <i class="fa fa-trash-alt mr-2"></i>Remover
        </button>

        <strong class="text-success text-lg">
            <span class="mr-2 text-gray">Total da Compra:</span>R$ 0,00
        </strong>
    </div>
    @endisset

</div>

<div id="modal-detalhes-produto" class="modal fade" data-field="fornecedor" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2 bg-dark bg-primary">
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

                    <div class="form-group col-xl-8">
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
                </div>

                <div class="form-row">

                    <!-- <div class="form-group col-xl-4">
                        <label>Custo Últ. Compra</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>

                            <input
                                type="number"
                                id="custo_ultima_compra"
                                name="custo_ultima_compra"
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

                    <div class="form-group col-xl-7">
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

                    <div class="form-group col-xl-2 required">
                        <label>Qtd.</label>
                        <input
                            type="number"
                            id="quantidade"
                            name="quantidade"
                            class="form-control"
                            step=".0001"
                            oninput="validity.valid || (value = '');"
                        >
                    </div>

                    <div class="form-group col-xl-3 required">
                        <label>Valor</label>

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
                                step=".01"
                                oninput="validity.valid || (value = '');"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between" id="total">
                <strong class="text-success text-lg">
                    <span class="mr-2 text-gray">Total:</span>R$ 0,00
                </strong>

                <button id="add-item" class="btn btn-success" data-dismiss="modal" disabled>
                    <i class="fa fa-plus mr-2"></i>Adicionar Item
                </button>
            </div>
        </div>
    </div>
</div>
