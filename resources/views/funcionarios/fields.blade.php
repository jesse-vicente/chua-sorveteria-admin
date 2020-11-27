<div class="form-row">
    <div class="form-group col-xl-1">
        <label>Código</label>
        <input
            type="number"
            id="id"
            name="id"
            class="form-control @error('id') is-invalid @enderror"
            value="{{ old('id', isset($funcionario) ? $funcionario->getId() : 0) }}"
            readonly
        >

        @error('id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-6">
        <label>Funcionário</label>
        <input
            type="text"
            id="funcionario"
            name="funcionario"
            class="form-control @error('funcionario') is-invalid @enderror"
            value="{{ old('funcionario', isset($funcionario) ? $funcionario->getNome() : null) }}"
            maxlength="50"
            required
        >

        @error('funcionario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-3">
        <label>Apelido</label>
        <input
            type="text"
            id="apelido"
            name="apelido"
            class="form-control @error('apelido') is-invalid @enderror"
            value="{{ old('apelido', isset($funcionario) ? $funcionario->getApelido() : null) }}"
            maxlength="20"
        >

        @error('apelido')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-2">
        <label>Sexo</label>
        <select class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
            @empty($funcionario))
                <option value="" selected class="d-none">Selecione</option>
                <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Feminino" {{ old('sexo') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
            @else
                <option value="Masculino" {{ $funcionario->getSexo() == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Feminino" {{ $funcionario->getSexo() == 'Feminino' ? 'selected' : '' }}>Feminino</option>
            @endif
        </select>

        @error('sexo')
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
            value="{{ old('endereco', isset($funcionario) ? $funcionario->getEndereco() : null) }}"
            maxlength="50"
            required
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
            value="{{ old('numero', isset($funcionario) ? $funcionario->getNumero() : null) }}"
            max="99999"
            required
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
            value="{{ old('complemento', isset($funcionario) ? $funcionario->getComplemento() : null) }}"
            maxlength="50"
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
            value="{{ old('bairro', isset($funcionario) ? $funcionario->getBairro() : null) }}"
            maxlength="50"
            required
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
            value="{{ old('cep', isset($funcionario) ? $funcionario->getCEP() : null) }}"
            placeholder="_____-___"
            required
        >

        @error('cep')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-1">
        <label>Código</label>
        <input
            type="number"
            class="form-control @error('cidade_id') is-invalid @enderror"
            name="cidade_id"
            id="cidade_id"
            data-input="#cidade"
            data-route="cidades"
            value="{{ old('cidade_id', isset($funcionario) ? $funcionario->getCidade()->getId() : null) }}"
        >

        @error('cidade_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-9">
        <label>Cidade</label>
        <div class="input-group">

            <input
                type="text"
                class="form-control"
                name="cidade"
                id="cidade"
                value="{{ old('cidade', isset($funcionario) ? $funcionario->getCidade()->getCidade() : null) }}"
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
            value="{{ old('whatsapp', isset($funcionario) ? $funcionario->getWhatsapp() : null) }}"
            placeholder="(__) _____-____"
            required
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
            value="{{ old('telefone', isset($funcionario) ? $funcionario->getTelefone() : null) }}"
            placeholder="(__) ____-____"
        >

        @error('telefone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-6">
        <label>E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', isset($funcionario) ? $funcionario->getEmail() : null) }}"
            maxlength="50"
            required
        >

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group required col-xl-3">
        <label>CPF</label>
        <input
            type="text"
            id="cpf"
            name="cpf"
            class="form-control @error('cpf') is-invalid @enderror"
            value="{{ old('cpf', isset($funcionario) ? $funcionario->getCpfCnpj() : null) }}"
            placeholder="___.___.___-__"
        >

        @error('cpf')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-3">
        <label>RG</label>
        <input
            type="text"
            id="rg" name="rg"
            class="form-control @error('rg') is-invalid @enderror"
            value="{{ old('rg', isset($funcionario) ? $funcionario->getRgInscricaoEstadual() : null) }}"
        >

        @error('rg')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Nascimento</label>
        <input
            type="date"
            id="data_nascimento"
            name="data_nascimento"
            class="form-control @error('data_nascimento') is-invalid @enderror"
            value="{{ old('data_nascimento', isset($funcionario) ? $funcionario->getDataNascimento() : null) }}"
            required
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
        <label>Salário</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>

            <input
                type="number"
                id="salario"
                name="salario"
                class="form-control @error('salario') is-invalid @enderror"
                value="{{ old('salario', isset($funcionario) ? $funcionario->getSalario() : null) }}"
                placeholder="0,00"
                step=".01"
                oninput="validity.valid || (value = '');"
                required
            >

            @error('salario')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group required col-xl-3">
        <label>Data de Admissão</label>
        <input
            type="date"
            id="data_admissao"
            name="data_admissao"
            class="form-control @error('data_admissao') is-invalid @enderror"
            value="{{ old('data_admissao', isset($funcionario) ? $funcionario->getDataAdmissao() : null) }}"
            required
        >

        @error('data_admissao')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-xl-3">
        <label>Data de Demissão</label>
        <input
            type="date"
            id="data_demissao"
            name="data_demissao"
            class="form-control @error('data_demissao') is-invalid @enderror"
            value="{{ old('data_demissao', isset($funcionario) ? $funcionario->getDataDemissao() : null) }}"
        >

        @error('data_demissao')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group col-xl-12 px-0">
    <label for="observacoes">Observações</label>
    <textarea
        name="observacoes"
        id="observacoes"
        class="form-control @error('observacoes') is-invalid @enderror"
        rows="3"
    >{{ old('observacoes', isset($funcionario) ? $funcionario->getObservacoes() : null) }}</textarea>

    @error('observacoes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
