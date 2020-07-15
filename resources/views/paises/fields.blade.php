<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="text"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($pais) ? $pais->getId() : null) }}"
            readonly
        >

        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>País</label>
        <input
            type="text"
            id="pais"
            name="pais"
            class="form-control @error('pais') is-invalid @enderror"
            value="{{ old('pais', isset($pais) ? $pais->getPais() : null) }}"
        >

        @error('pais')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-1">
        <label>Sigla</label>
        <input
            type="text"
            id="sigla"
            name="sigla"
            class="form-control @error('sigla') is-invalid @enderror"
            value="{{ old('sigla', isset($pais) ? $pais->getSigla() : null) }}"
        >

        @error('sigla')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-1">
        <label>DDI</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">+</span>
            </div>

            <input
                type="number"
                id="ddi"
                name="ddi"
                class="form-control @error('ddi') is-invalid @enderror"
                value="{{ old('ddi', isset($pais) ? $pais->getDDI() : null) }}"
            >

            @error('ddi')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
