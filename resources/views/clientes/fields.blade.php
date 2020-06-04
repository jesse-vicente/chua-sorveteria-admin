<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Cliente</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($cliente)
            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('clientes.store') }}">
        @endif

            @csrf
            <div class="form-row">

                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $cliente->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Cliente <span class="text-danger">*</span></label>
                    <input type="text" id="cliente" name="cliente" class="form-control @error('cliente') @errror is-invalid @enderror" value="{{ old('cliente', $cliente->cliente ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('cliente')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') @errror is-invalid @enderror" value="{{ old('telefone', $cliente->telefone ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" id="whatsapp" name="whatsapp" class="form-control @error('whatsapp') @errror is-invalid @enderror" value="{{ old('whatsapp', $cliente->whatsapp ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('whatsapp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>E-mail</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') @errror is-invalid @enderror" value="{{ old('email', $cliente->email ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Endereço <span class="text-danger">*</span></label>
                    <input type="text" id="endereco" name="endereco" class="form-control @error('endereco') @errror is-invalid @enderror" value="{{ old('endereco', $cliente->endereco ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Número <span class="text-danger">*</span></label>
                    <input type="text" id="numero" name="numero" class="form-control @error('numero') @errror is-invalid @enderror" value="{{ old('numero', $cliente->numero ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Complemento</label>
                    <input type="text" id="complemento" name="complemento" class="form-control @error('complemento') @errror is-invalid @enderror" value="{{ old('complemento', $cliente->complemento ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('complemento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>CEP <span class="text-danger">*</span></label>
                    <input type="text" id="cep" name="cep" class="form-control @error('cep') @errror is-invalid @enderror" value="{{ old('cep', $cliente->cep ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('cep')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Bairro <span class="text-danger">*</span></label>
                    <input type="text" id="bairro" name="bairro" class="form-control @error('bairro') @errror is-invalid @enderror" value="{{ old('bairro', $cliente->bairro ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('bairro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Cidade <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="cidade_id" value="{{ old('cidade_id', $cliente->cidade_id ?? null) }}" />
                        <input class="form-control" name="cidade" value="{{ old('cidade', $cliente->cidade ?? null) }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search" type="button" data-route="cidades" data-toggle="modal" data-target="#modal-cidades">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-cidades" class="modal fade" data-field="cidade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary align-items-center py-2">
                                <h3 class="modal-title">Buscar Cidade</h3>
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
                    <label>CPF <span class="text-danger">*</span></label>
                    <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control @error('cpf_cnpj') @errror is-invalid @enderror" value="{{ old('cpf_cnpj', $cliente->cpf_cnpj ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('cpf_cnpj')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>RG</label>
                    <input type="text" id="inscricao_estadual" name="inscricao_estadual" class="form-control @error('inscricao_estadual') @errror is-invalid @enderror" value="{{ old('inscricao_estadual', $cliente->inscricao_estadual ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('inscricao_estadual')
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
                        value="{{ old('data_cadastro', (isset($cliente)) ? $cliente->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($cliente)) ? $cliente->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('clientes.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>
