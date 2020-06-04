<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Cidade</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($cidade)
        <form method="POST" action="{{ route('cidades.update', $cidade->id) }}">
            @method('PUT')
        @else
        <form method="POST" action="{{ route('cidades.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $cidade->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Cidade <span class="text-danger">*</span></label>
                    <input type="text" id="cidade" name="cidade" class="form-control @error('cidade') @errror is-invalid @enderror" value="{{ old('cidade', $cidade->cidade ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('cidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>DDD <span class="text-danger">*</span></label>
                    <input type="text" id="ddd" name="ddd" class="form-control @error('ddd') @errror is-invalid @enderror" value="{{ old('ddd', $cidade->ddd ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('ddd')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Estado <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="estado_id" value="{{ old('estado_id', $cidade->estado_id ?? null) }}" />
                        <input class="form-control" name="estado" value="{{ old('estado', $cidade->estado ?? null) }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search" type="button" data-route="estados" data-toggle="modal" data-target="#modal-estados">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-estados" class="modal fade" data-field="estado" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary align-items-center py-2">
                                <h3 class="modal-title">Buscar Estado</h3>
                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive"></div>
                            </div>
                        </div>
                    </div>
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
                        value="{{ old('data_cadastro', (isset($cidade)) ? $cidade->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($cidade)) ? $cidade->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('cidades.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>
