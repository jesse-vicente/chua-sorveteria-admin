<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar País</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($pais)
            <form method="POST" action="{{ route('paises.update', $pais ?? $pais->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('paises.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $pais->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>País <span class="text-danger">*</span></label>
                    <input type="text" id="pais" name="pais" class="form-control @error('pais') @errror is-invalid @enderror" value="{{ old('pais', $pais->pais ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('pais')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Sigla <span class="text-danger">*</span></label>
                    <input type="text" id="sigla" name="sigla" class="form-control @error('sigla') @errror is-invalid @enderror" value="{{ old('sigla', $pais->sigla ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('sigla')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>DDI <span class="text-danger">*</span></label>
                    <input type="text" id="ddi" name="ddi" class="form-control @error('ddi') @errror is-invalid @enderror" value="{{ old('ddi', $pais->ddi ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('ddi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Data de Cadastro</label>
                    <input
                        type="date"
                        id="data_cadastro"
                        name="data_cadastro"
                        class="form-control @error('data_cadastro') @errror is-invalid @enderror"
                        value="{{ old('data_cadastro', (isset($pais)) ? $pais->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
                        onkeyup="toUpper(this)"
                        autofocus
                        readonly>

                    @error('data_cadastro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Data Últ. Alteração</label>
                    <input
                        type="date"
                        id="data_alteracao"
                        name="data_alteracao"
                        class="form-control @error('data_alteracao') @errror is-invalid @enderror"
                        value="{{ old('data_alteracao', (isset($pais)) ? $pais->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
                        onkeyup="toUpper(this)"
                        autofocus
                        readonly>

                    @error('data_alteracao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row mb-0">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Salvar
                    </button>
                    <a class="btn btn-secondary" href="{{ route('paises.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>
