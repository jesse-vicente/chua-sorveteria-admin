<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($cliente) ? $cliente->getId() : 0) }}"
            readonly
        >

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-7">
        <label>Cliente</label>
        <input
            type="text"
            id="cliente"
            name="cliente"
            class="form-control @error('cliente') is-invalid @enderror"
            value="{{ old('cliente', isset($cliente) ? $cliente->getNome() : null) }}"
        >

        @error('cliente')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-4">
        <label>Apelido</label>
        <input
            type="text"
            id="apelido"
            name="apelido"
            class="form-control @error('apelido') is-invalid @enderror"
            value="{{ old('apelido', isset($cliente) ? $cliente->getApelido() : null) }}"
        >

        @error('apelido')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row mt-4">
    <div class="form-group required col-xl-5">
        <label>Logradouro</label>
        <input
            type="text"
            id="endereco"
            name="endereco"
            class="form-control @error('endereco') is-invalid @enderror"
            value="{{ old('endereco', isset($cliente) ? $cliente->getEndereco() : null) }}"
        >

        @error('endereco')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Número</label>
        <input
            type="number"
            id="numero"
            name="numero"
            class="form-control @error('numero') is-invalid @enderror"
            value="{{ old('numero', isset($cliente) ? $cliente->getNumero() : null) }}"
        >

        @error('numero')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Complemento</label>
        <input
            type="text"
            id="complemento"
            name="complemento"
            class="form-control @error('complemento') is-invalid @enderror"
            value="{{ old('complemento', isset($cliente) ? $cliente->getComplemento() : null) }}"
        >

        @error('complemento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-3">
        <label>Bairro</label>
        <input
            type="text"
            id="bairro"
            name="bairro"
            class="form-control @error('bairro') is-invalid @enderror"
            value="{{ old('bairro', isset($cliente) ? $cliente->getBairro() : null) }}"
        >

        @error('bairro')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>CEP</label>
        <input
            type="text"
            id="cep"
            name="cep"
            class="form-control @error('cep') is-invalid @enderror"
            value="{{ old('cep', isset($cliente) ? $cliente->getCEP() : null) }}"
            placeholder="_____-___"
        >

        @error('cep')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('cidade_id') is-invalid @enderror"
            name="cidade_id"
            id="cidade_id"
            data-input="#cidade"
            data-route="cidades"
            value="{{ old('cidade_id', isset($cliente) ? $cliente->getCidade()->getId() : null) }}"
        >

        @error('cidade_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-8">
        <label>Cidade</label>
        <div class="input-group">
            <input
                class="form-control"
                name="cidade"
                id="cidade"
                value="{{ old('cidade', isset($cliente) ? $cliente->getCidade()->getCidade() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#cidade_id"
                    data-route="cidades"
                    data-toggle="modal"
                    data-target="#modal-cidades"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-cidades" class="modal fade" data-field="cidade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Cidade</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('cidades.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row mt-4">
    <div class="form-group required col-xl-3">
        <label>WhatsApp</label>
        <input
            type="text"
            id="whatsapp"
            name="whatsapp"
            class="form-control @error('whatsapp') is-invalid @enderror"
            value="{{ old('whatsapp', isset($cliente) ? $cliente->getWhatsapp() : null) }}"
            placeholder="(__) _____-____"
        >

        @error('whatsapp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-3">
        <label>Telefone</label>
        <input
            type="text"
            id="telefone"
            name="telefone"
            class="form-control @error('telefone') is-invalid @enderror"
            value="{{ old('telefone', isset($cliente) ? $cliente->getTelefone() : null) }}"
            placeholder="(__) ____-____"
        >

        @error('telefone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-6">
        <label>E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', isset($cliente) ? $cliente->getEmail() : null) }}"
        >

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-4">
        <label>CPF</label>
        <input
            type="text"
            id="cpf"
            name="cpf"
            class="form-control @error('cpf') is-invalid @enderror"
            value="{{ old('cpf', isset($cliente) ? $cliente->getCpfCnpj() : null) }}"
            placeholder="___.___.___-__"
        >

        @error('cpf')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-4">
        <label>RG</label>
        <input
            type="text"
            id="rg"
            name="rg"
            class="form-control @error('rg') is-invalid @enderror"
            value="{{ old('rg', isset($cliente) ? $cliente->getRgInscricaoEstadual() : null) }}"
        >

        @error('rg')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-4">
        <label>Data de Nascimento</label>
        <input
            type="date"
            id="data_nascimento"
            name="data_nascimento"
            class="form-control @error('data_nascimento') is-invalid @enderror"
            value="{{ old('data_nascimento', isset($cliente) ? $cliente->getDataNascimento() : null) }}"
        >

        @error('data_nascimento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row mt-4">
    <div class="form-group required col-xl-2">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('condicao_pagamento_id') is-invalid @enderror"
            name="condicao_pagamento_id"
            id="condicao_pagamento_id"
            data-input="#condicao_pagamento"
            data-route="condicoes-pagamento"
            value="{{ old('condicao_pagamento_id', isset($cliente) ? $cliente->getCondicaoPagamento()->getId() : null) }}"
        >

        @error('condicao_pagamento_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-10">
        <label>Condição de Pagamento</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                name="condicao_pagamento"
                id="condicao_pagamento"
                value="{{ old('condicao_pagamento', isset($cliente) ? $cliente->getCondicaoPagamento()->getCondicaoPagamento() : null) }}"
                readonly
            >

            <div class="input-group-append">
                <button
                    class="btn btn-primary btn-search"
                    type="button"
                    data-input="#condicao_pagamento_id"
                    data-route="condicoes-pagamento"
                    data-toggle="modal"
                    data-target="#modal-condicoes-pagamento"
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="modal-condicoes-pagamento" class="modal fade" data-field="condicao_pagamento" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2 bg-dark">
                    <h3 class="modal-title">Buscar Condição de Pagamento</h3>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('condicoes-pagamento.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group col-xl-12 px-0">
    <label for="observacoes">Observações</label>
    <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes', isset($cliente) ? $cliente->getObservacoes() : null) }}</textarea>
</div>
