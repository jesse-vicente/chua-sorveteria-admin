<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Funcionário</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($funcionario)
            <form method="POST" action="{{ route('funcionarios.update', $funcionario->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('funcionarios.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $funcionario->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>Funcionário <span class="text-danger">*</span></label>
                    <input type="text" id="funcionario" name="funcionario" class="form-control @error('funcionario') @errror is-invalid @enderror" value="{{ old('funcionario', $funcionario->funcionario ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('funcionario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group ml-2">
                    <label>Sexo <span class="text-danger">*</span></label>
                    <div class="form-row mx-0">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="masculino" name="genero" class="custom-control-input" value="Masculino" required>
                            <label class="custom-control-label" for="masculino">Masculino</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="feminino" name="genero" class="custom-control-input" value="Feminino" required>
                            <label class="custom-control-label" for="feminino">Feminino</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') @errror is-invalid @enderror" value="{{ old('telefone', $funcionario->telefone ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" id="whatsapp" name="whatsapp" class="form-control @error('whatsapp') @errror is-invalid @enderror" value="{{ old('whatsapp', $funcionario->whatsapp ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('whatsapp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>E-mail</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') @errror is-invalid @enderror" value="{{ old('email', $funcionario->email ?? null) }}" onkeyup="toUpper(this)" autofocus>

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
                    <input type="text" id="endereco" name="endereco" class="form-control @error('endereco') @errror is-invalid @enderror" value="{{ old('endereco', $funcionario->endereco ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Número</label>
                    <input type="text" id="numero" name="numero" class="form-control @error('numero') @errror is-invalid @enderror" value="{{ old('numero', $funcionario->numero ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Complemento</label>
                    <input type="text" id="complemento" name="complemento" class="form-control @error('complemento') @errror is-invalid @enderror" value="{{ old('complemento', $funcionario->complemento ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('complemento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>CEP <span class="text-danger">*</span></label>
                    <input type="text" id="cep" name="cep" class="form-control @error('cep') @errror is-invalid @enderror" value="{{ old('cep', $funcionario->cep ?? null) }}" onkeyup="toUpper(this)" autofocus required>

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
                    <input type="text" id="bairro" name="bairro" class="form-control @error('bairro') @errror is-invalid @enderror" value="{{ old('bairro', $funcionario->bairro ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('bairro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Cidade <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="cidade_id" value="{{ old('cidade_id', $funcionario->cidade_id ?? null) }}" />
                        <input class="form-control" name="cidade" value="{{ old('cidade', $funcionario->cidade ?? null) }}" />
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
                    <input type="text" id="cpf" name="cpf" class="form-control @error('cpf') @errror is-invalid @enderror" value="{{ old('cpf', $funcionario->cpf ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('cpf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>RG <span class="text-danger">*</span></label>
                    <input type="text" id="rg" name="rg" class="form-control @error('rg') @errror is-invalid @enderror" value="{{ old('rg', $funcionario->rg ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('rg')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control @error('data_nascimento') @errror is-invalid @enderror" value="{{ old('data_nascimento', $funcionario->data_nascimento ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('data_nascimento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Salário <span class="text-danger">*</span></label>
                    <input type="text" id="salario" name="salario" class="form-control @error('salario') @errror is-invalid @enderror" value="{{ old('salario', $funcionario->salario ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('salario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Data de Admissão <span class="text-danger">*</span></label>
                    <input type="date" id="data_admissao" name="data_admissao" class="form-control @error('data_admissao') @errror is-invalid @enderror" value="{{ old('data_admissao', $funcionario->data_admissao ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('data_admissao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Data de Demissão</label>
                    <input type="date" id="data_demissao" name="data_demissao" class="form-control @error('data_demissao') @errror is-invalid @enderror" value="{{ old('data_demissao', $funcionario->data_demissao ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('data_demissao')
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
                        value="{{ old('data_cadastro', (isset($funcionario)) ? $funcionario->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($funcionario)) ? $funcionario->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('funcionarios.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
