<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Forma de Pagamento</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($forma_pagamento)
            <form method="POST" action="{{ route('formas-pagamento.update', $forma_pagamento->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('formas-pagamento.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $formaPagamento->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Forma de Pagamento <span class="text-danger">*</span></label>
                    <input type="text" id="forma_pagamento" name="forma_pagamento" class="form-control @error('forma_pagamento') @errror is-invalid @enderror" value="{{ old('forma_pagamento', $formaPagamento->forma_pagamento ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('forma_pagamento')
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
                        value="{{ old('data_cadastro', (isset($formaPagamento)) ? $formaPagamento->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($formaPagamento)) ? $formaPagamento->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('formas-pagamento.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>
