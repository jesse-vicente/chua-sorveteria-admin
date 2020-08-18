@if (!isset($fornecedor))
<div class="form-group">
    <label>Pessoa</label>
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
@endif

<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="text"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($fornecedor) ? $fornecedor->getId() : null) }}"
            readonly
        >

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-3">
        <label>Fornecedor</label>
        <input
            type="text"
            id="fornecedor"
            name="fornecedor"
            class="form-control @error('fornecedor') is-invalid @enderror"
            value="{{ old('fornecedor', isset($fornecedor) ? $fornecedor->getRazaoSocial() : null) }}"
        >

        @error('fornecedor')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Nome Fantasia</label>
        <input
            type="text"
            id="nome_fantasia"
            name="nome_fantasia"
            class="form-control @error('nomeFantasia') is-invalid @enderror"
            value="{{ old('nomeFantasia', isset($fornecedor) ? $fornecedor->getNomeFantasia() : null) }}"
        >

        @error('nomeFantasia')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>Endereço</label>
        <input
            type="text"
            id="endereco"
            name="endereco"
            class="form-control @error('endereco') is-invalid @enderror"
            value="{{ old('endereco', isset($fornecedor) ? $fornecedor->getEndereco() : null) }}"
        >

        @error('endereco')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-1">
        <label>Número</label>
        <input
            type="number"
            id="numero"
            name="numero"
            class="form-control @error('numero') is-invalid @enderror"
            value="{{ old('numero', isset($fornecedor) ? $fornecedor->getNumero() : null) }}"
        >

        @error('numero')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-1">
        <label>Complemento</label>
        <input
            type="text"
            id="complemento"
            name="complemento"
            class="form-control @error('complemento') is-invalid @enderror"
            value="{{ old('complemento', isset($fornecedor) ? $fornecedor->getComplemento() : null) }}"
        >

        @error('complemento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Bairro</label>
        <input
            type="text"
            id="bairro"
            name="bairro"
            class="form-control @error('bairro') is-invalid @enderror"
            value="{{ old('bairro', isset($fornecedor) ? $fornecedor->getBairro() : null) }}"
        >

        @error('bairro')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-1">
        <label>CEP</label>
        <input
            type="text"
            id="cep"
            name="cep"
            class="form-control @error('cep') is-invalid @enderror"
            value="{{ old('cep', isset($fornecedor) ? $fornecedor->getCEP() : null) }}"
            placeholder="_____-___"
        >

        @error('cep')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-1">
        <label>Código</label>

        <input
            type="number"
            class="form-control @error('cidade_id') is-invalid @enderror"
            name="cidade_id"
            id="cidade_id"
            data-input="#cidade"
            data-route="cidades"
            value="{{ old('cidade_id', isset($fornecedor) ? $fornecedor->getCidade()->getId() : null) }}"
        >

        @error('cidade_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-4">
        <label>Cidade</label>
        <div class="input-group mb-3">
            <input
                class="form-control"
                name="cidade"
                id="cidade"
                value="{{ old('cidade', isset($fornecedor) ? $fornecedor->getCidade()->getCidade() : null) }}"
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Cidade</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('cidades.search')
                </div>
            </div>
        </div>
    </div>

</div>

<div class="form-row">
    <div class="form-group col-xl-2">
        <label>Telefone</label>
        <input
            type="text"
            id="telefone"
            name="telefone"
            class="form-control @error('telefone') is-invalid @enderror"
            value="{{ old('telefone', isset($fornecedor) ? $fornecedor->getTelefone() : null) }}"
            placeholder="(__) ____-____"
        >

        @error('telefone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>WhatsApp</label>
        <input
            type="text"
            id="whatsapp"
            name="whatsapp"
            class="form-control @error('whatsapp') is-invalid @enderror"
            value="{{ old('whatsapp', isset($fornecedor) ? $fornecedor->getWhatsapp() : null) }}"
            placeholder="(__) _____-____"
        >

        @error('whatsapp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', isset($fornecedor) ? $fornecedor->getEmail() : null) }}"
        >

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-xl-3">
        <label>Site</label>
        <input
            type="url"
            id="website"
            name="website"
            class="form-control @error('website') is-invalid @enderror"
            value="{{ old('website', isset($fornecedor) ? $fornecedor->getWebSite() : null) }}"
        >

        @error('website')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-3">
        <label>Contato</label>
        <input
            type="text"
            id="contato"
            name="contato"
            class="form-control @error('contato') is-invalid @enderror"
            value="{{ old('contato', isset($fornecedor) ? $fornecedor->getContato() : null) }}"
        >

        @error('contato')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">

    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('condicao_pagamento_id') is-invalid @enderror"
            name="condicao_pagamento_id"
            id="condicao_pagamento_id"
            data-input="#condicao_pagamento"
            data-route="condicoes-pagamento"
            value="{{ old('condicao_pagamento_id', isset($fornecedor) ? $fornecedor->getCondicaoPagamento()->getId() : null) }}"
        >

        @error('condicao_pagamento_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-5">
        <label>Condição de Pagamento</label>
        <div class="input-group mb-3">

            <input
                type="text"
                class="form-control"
                name="condicao_pagamento"
                id="condicao_pagamento"
                value="{{ old('condicao_pagamento', isset($fornecedor) ? $fornecedor->getCondicaoPagamento()->getCondicaoPagamento() : null) }}"
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header align-items-center py-2">
                    <h3 class="modal-title">Buscar Condição de Pagamento</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('condicoes-pagamento.search')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-2">
        <label>CNPJ</label>
        <input
            type="text"
            id="cpf_cnpj"
            name="cpf_cnpj"
            class="form-control @error('cpf_cnpj') is-invalid @enderror"
            value="{{ old('cpf_cnpj', isset($fornecedor) ? $fornecedor->getCpfCnpj() : null) }}"
            placeholder="__.___.___/____-__"
        >

        @error('cpf_cnpj')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Inscrição Estadual</label>
        <input
            type="text"
            id="rg_inscricao_estadual"
            name="rg_inscricao_estadual"
            class="form-control @error('rg_inscricao_estadual') is-invalid @enderror"
            value="{{ old('rg_inscricao_estadual', isset($fornecedor) ? $fornecedor->getRgInscricaoEstadual() : null) }}"
        >

        @error('rg_inscricao_estadual')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-2">
        <label>Limite de Crédito</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="text"
                id="valor_credito"
                name="valor_credito"
                class="form-control @error('valor_credito') is-invalid @enderror"
                value="{{ old('valor_credito', isset($fornecedor) ? $fornecedor->getValorCredito() : null) }}"
            >
        </div>

        @error('valor_credito')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group col-xl-6 px-0">
    <label for="observacoes">Observações</label>
    <textarea
        name="observacoes"
        id="observacoes"
        class="form-control @error('observacoes') is-invalid @enderror"
        rows="3"
    >{{ old('observacoes', isset($fornecedor) ? $fornecedor->getObservacoes() : null) }}</textarea>

    @error('observacoes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
