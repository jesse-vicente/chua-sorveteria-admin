<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($pais) ? $pais->getId() : 0) }}"
            readonly
        >

        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-6">
        <label>País</label>
        <input
            type="text"
            id="pais"
            name="pais"
            class="form-control @error('pais') is-invalid @enderror"
            value="{{ old('pais', isset($pais) ? $pais->getPais() : null) }}"
            maxlength="50"
            required
        >

        @error('pais')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Sigla</label>
        <input
            type="text"
            id="sigla"
            name="sigla"
            class="form-control @error('sigla') is-invalid @enderror"
            value="{{ old('sigla', isset($pais) ? $pais->getSigla() : null) }}"
            maxlength="3"
            required
        >

        @error('sigla')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
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
                min="1"
                max="999"
                oninput="validity.valid || (value = '');"
                required
            >

            @error('ddi')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
