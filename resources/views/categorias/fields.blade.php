<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="text"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($categoria) ? $categoria->getId() : null) }}"
            readonly
        >

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-10">
        <label>Categoria</label>
        <input
            type="text"
            id="categoria"
            name="categoria"
            class="form-control @error('categoria') is-invalid @enderror"
            value="{{ old('categoria', isset($categoria) ? $categoria->getCategoria() : null) }}"
        >

        @error('categoria')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
