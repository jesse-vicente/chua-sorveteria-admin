<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Fornecedor</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($fornecedor)
            <form method="POST" action="{{ route('fornecedores.update', $fornecedor->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('fornecedores.store') }}">
        @endif

            @csrf
            <div class="form-group">
                <label>Pessoa <span class="text-danger">*</span></label>
                <div class="form-row mx-0">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="juridica" name="tipo_pessoa" class="custom-control-input" value="Jurídica" required checked>
                        <label class="custom-control-label" for="juridica">Jurídica</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="fisica" name="tipo_pessoa" class="custom-control-input" value="Física" required>
                        <label class="custom-control-label" for="fisica">Física</label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $fornecedor->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>Fornecedor <span class="text-danger">*</span></label>
                    <input type="text" id="fornecedor" name="fornecedor" class="form-control @error('fornecedor') @errror is-invalid @enderror" value="{{ old('fornecedor', $fornecedor->fornecedor ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('fornecedor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>Nome Fantasia</label>
                    <input type="text" id="nome_fantasia" name="nome_fantasia" class="form-control @error('nomeFantasia') @errror is-invalid @enderror" value="{{ old('nomeFantasia', $fornecedor->nomeFantasia ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('nomeFantasia')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Endereço <span class="text-danger">*</span></label>
                    <input type="text" id="endereco" name="endereco" class="form-control @error('endereco') @errror is-invalid @enderror" value="{{ old('endereco', $fornecedor->endereco ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('endereco')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Número <span class="text-danger">*</span></label>
                    <input type="text" id="numero" name="numero" class="form-control @error('numero') @errror is-invalid @enderror" value="{{ old('numero', $fornecedor->numero ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Complemento</label>
                    <input type="text" id="complemento" name="complemento" class="form-control @error('complemento') @errror is-invalid @enderror" value="{{ old('complemento', $fornecedor->complemento ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('complemento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>CEP <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        id="cep"
                        name="cep"
                        class="form-control @error('cep') @errror is-invalid @enderror"
                        value="{{ old('cep', $fornecedor->cep ?? null) }}"
                        onkeyup="toUpper(this)"
                        autofocus
                        required>

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
                    <input type="text" id="bairro" name="bairro" class="form-control @error('bairro') @errror is-invalid @enderror" value="{{ old('bairro', $fornecedor->bairro ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('bairro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Cidade <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="cidade_id" value="{{ old('cidade_id', $fornecedor->cidade_id ?? null) }}" />
                        <input class="form-control" name="cidade" value="{{ old('cidade', $fornecedor->cidade ?? null) }}" />
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
                <div class="form-group col-md-1">
                    <label>Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') @errror is-invalid @enderror" value="{{ old('telefone', $fornecedor->telefone ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('telefone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" id="whatsapp" name="whatsapp" class="form-control @error('whatsapp') @errror is-invalid @enderror" value="{{ old('whatsapp', $fornecedor->whatsapp ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('whatsapp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>E-mail</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') @errror is-invalid @enderror" value="{{ old('email', $fornecedor->email ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Site</label>
                    <input type="url" id="site" name="site" class="form-control @error('site') @errror is-invalid @enderror" value="{{ old('site', $fornecedor->site ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('site')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Contato</label>
                    <input type="text" id="contato" name="contato" class="form-control @error('contato') @errror is-invalid @enderror" value="{{ old('contato', $fornecedor->contato ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('contato')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Condição de Pagamento <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="condicao_pagamento_id" value="{{ old('condicao_pagamento_id', $fornecedor->condicao_pagamento_id ?? null) }}" />
                        <input type="text" class="form-control" name="condicao_pagamento" value="{{ old('condicao_pagamento', $fornecedor->condicao_pagamento ?? null) }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search" type="button" data-route="condicao_pagamentos" data-toggle="modal" data-target="#modal-condicoes_pagamento">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-condicoes_pagamento" class="modal fade" data-field="condicao_pagamento" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary align-items-center py-2">
                                <h3 class="modal-title">Buscar Condição de Pagamento</h3>
                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label>CNPJ <span class="text-danger">*</span></label>
                    <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control @error('cpf_cnpj') @errror is-invalid @enderror" value="{{ old('cpf_cnpj', $fornecedor->cpf_cnpj ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('cpf_cnpj')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Inscrição Estadual</label>
                    <input type="text" id="inscricao_estadual" name="inscricao_estadual" class="form-control @error('inscricao_estadual') @errror is-invalid @enderror" value="{{ old('inscricao_estadual', $fornecedor->inscricao_estadual ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('inscricao_estadual')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Valor de Crédito</label>
                    <input type="text" id="valor_credito" name="valor_credito" class="form-control @error('valor_credito') @errror is-invalid @enderror" value="{{ old('valor_credito', $fornecedor->valor_credito ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('valor_credito')
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
                        value="{{ old('data_cadastro', (isset($fornecedor)) ? $fornecedor->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($fornecedor)) ? $fornecedor->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('fornecedores.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>
