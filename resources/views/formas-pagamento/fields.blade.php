<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($formaPagamento) ? $formaPagamento->getId() : 0) }}"
            readonly
        >

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-10">
        <label>Forma de Pagamento</label>
        <input
            type="text"
            id="forma_pagamento"
            name="forma_pagamento"
            class="form-control @error('forma_pagamento') is-invalid @enderror"
            value="{{ old('forma_pagamento', isset($formaPagamento) ? $formaPagamento->getFormaPagamento() : null) }}"
        >

        @error('forma_pagamento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
