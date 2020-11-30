<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($condicaoPagamento) ? $condicaoPagamento->getId() : 0) }}"
            readonly
        />

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-5">
        <label>Condição de Pagamento</label>

        <input
            type="text"
            id="condicao_pagamento"
            name="condicao_pagamento"
            class="form-control @error('condicao_pagamento') is-invalid @enderror"
            value="{{ old('condicaoPagamento', isset($condicaoPagamento) ? $condicaoPagamento->getCondicaoPagamento() : null) }}"
            required
        />

        @error('condicao_pagamento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Juros</label>

        <div class="input-group">
            <input
                type="number"
                id="juros"
                name="juros"
                class="form-control @error('juros') is-invalid @enderror"
                value="{{ old('juros', isset($condicaoPagamento) ? $condicaoPagamento->getJuros() : null) }}"
            />

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

    <div class="form-group col-xl-2">
        <label>Multa</label>

        <div class="input-group">
            <input
                type="number"
                id="multa"
                name="multa"
                class="form-control @error('multa') is-invalid @enderror"
                value="{{ old('multa', isset($condicaoPagamento) ? $condicaoPagamento->getMulta() : null) }}"
            />

            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>

            @error('multa')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-xl-2">
        <label>Desconto</label>

        <div class="input-group">
            <input
                type="number"
                id="desconto"
                name="desconto"
                class="form-control @error('desconto') is-invalid @enderror"
                value="{{ old('desconto', isset($condicaoPagamento) ? $condicaoPagamento->getDesconto() : null) }}"
            />

            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>

            @error('desconto')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<button type="button" class="btn btn-block btn-primary add-new my-3">
    <i class="fa fa-plus mr-1"></i>
    <span>Adicionar Parcela</span>
</button>

<div class="d-flex mt-4">
    <hr class="flex-grow-1">
    <div class="px-4">
        <h4 class="text-gray">
            <i class="fa fa-file-invoice-dollar mr-1"></i>
            Parcelas
        </h4>
    </div>
    <hr class="flex-grow-1">
</div>

<div class="table-wrapper mb-4">
    @include('condicoes-pagamento.parcelas-table')
</div>

<div id="modal-formas-pagamento" class="modal fade" data-field="forma_pagamento[]" role="dialog">
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

<input
    type="hidden"
    id="total_parcelas"
    name="total_parcelas"
    value="{{ old('total_parcelas', isset($condicaoPagamento) ? $condicaoPagamento->getTotalParcelas() : null) }}"
    readonly
/>
