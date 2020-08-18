<div class="card">
    <div class="card-header bg-gradient-light">
        <span class="d-flex align-items-center">
            <i class="fa fa-shopping-cart mr-2"></i>
            <h5 class="mb-0">Lista de Produtos</h5>
        </span>
    </div>

    <div class="card-body" style="display: none;">
        <table class="table table-hover table-sm table-striped" id="produtos-table"></table>
    </div>

    <!-- <div class="card-footer d-flex justify-content-end">
        <button id='remove-item' class="pull-right btn btn-danger" disabled>
            <i class="fa fa-trash-alt mr-2"></i>Remover Item
        </button>
    </div> -->
</div>

<div id="modal-detalhes-produto" class="modal fade" data-field="fornecedor" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2 bg-primary">
                <h3 class="modal-title">Detalhes da Compra</h3>
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

                    <div class="form-group col-xl-10">
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
                </div>

                <div class="form-row">
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

                    <div class="form-group col-xl-10">
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
                </div>

                <div class="form-row">
                    <div class="form-group col-xl-4 required">
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
                    </div>

                    <div class="form-group col-xl-4 required">
                        <label>Valor</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>

                            <input
                                type="number"
                                id="valor"
                                name="valor"
                                placeholder="0,00"
                                class="form-control"
                            >
                        </div>
                    </div>

                    <div class="form-group col-xl-4">
                        <label>Total</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </div>

                            <input
                                type="number"
                                id="total"
                                name="total"
                                placeholder="0,00"
                                class="form-control"
                                readonly
                                disabled
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="add-item" class="pull-right btn btn-success" data-dismiss="modal" disabled>
                    <i class="fa fa-plus mr-2"></i>Adicionar Item
                </button>
            </div>
        </div>
    </div>
</div>
