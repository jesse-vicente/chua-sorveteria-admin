<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Estado</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($estado)
            <form method="POST" action="{{ route('estados.update', $estado->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('estados.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $estado->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Estado <span class="text-danger">*</span></label>
                    <input type="text" id="estado" name="estado" class="form-control @error('estado') @errror is-invalid @enderror" value="{{ old('estado', $estado->estado ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('estado')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>UF <span class="text-danger">*</span></label>
                    <input type="text" id="uf" name="uf" class="form-control @error('uf') @errror is-invalid @enderror" value="{{ old('uf', $estado->uf ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('uf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>País <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="pais_id" value="{{ old('pais_id', $estado->pais_id ?? null) }}" />
                        <input class="form-control" name="pais" value="{{ old('pais', $estado->pais ?? null) }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search" type="button" data-route="paises" data-toggle="modal" data-target="#modal-paises">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-paises" data-field="pais" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary align-items-center py-2">
                                <h3 class="modal-title">Buscar País</h3>
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
                        value="{{ old('data_cadastro', (isset($estado)) ? $estado->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($estado)) ? $estado->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('estados.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>
