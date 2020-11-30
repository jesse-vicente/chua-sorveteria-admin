<div class="card mt-4">
    <div class="card-body p-0">
        <table id="parcelas-table" class="table table-striped table-borderless border-right w-100">
            <thead>
                <tr>
                    <th class="d-none">Cód. Parcela</th>
                    <th style="width: 5%;">Parcela</th>
                    <th>Forma de Pagamento <span style="color: #f00;">*</span></th>
                    <th style="width: 15%;">Prazo <span style="color: #f00;">*</span></th>
                    <th style="width: 15%;">Percentual <span style="color: #f00;">*</span></th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($condicaoPagamento) && $condicaoPagamento->getTotalParcelas() > 0)
                    @foreach ($condicaoPagamento->getParcelas() as $i => $parcela)
                        <tr>
                            <td class="d-none parcela_id">{{ $parcela->getId() }}</td>
                            <td>
                                <input
                                    type="number"
                                    class="form-control numero-parcela"
                                    name="parcelas[]"
                                    value="{{ $parcela->getNumero() }}"
                                    required
                                    readonly
                                >
                            </td>
                            <td>
                                <div class="form-row">
                                    <div class="form-group col-xl-2 mb-0">
                                        <input
                                            type="text"
                                            placeholder="Cód."
                                            class="form-control forma-pagamento-id"
                                            name="forma_pagamento_id[]"
                                            id="forma_pagamento_id[]"
                                            data-input="#forma_pagamento_{{ $i }}"
                                            data-route="formas-pagamento"
                                            value="{{ $parcela->getFormaPagamento()->getId() }}"
                                            readonly
                                            required
                                        >
                                    </div>

                                    <div class="form-group col-md-10 mb-0">
                                        <div class="input-group">

                                            <input
                                                type="text"
                                                class="form-control forma-pagamento"
                                                name="forma_pagamento[]"
                                                id="forma_pagamento_{{ $i }}"
                                                value="{{ $parcela->getFormaPagamento()->getFormaPagamento() }}"
                                                min="1"
                                                step="1"
                                                oninput="validity.valid || (value = '');"
                                                readonly
                                                required
                                            >

                                            <div class="input-group-append">
                                                <button
                                                    class="btn btn-primary btn-search"
                                                    type="button"
                                                    data-input="#forma_pagamento_id"
                                                    data-route="formas-pagamento"
                                                    data-toggle="modal"
                                                    data-target="#modal-formas-pagamento"
                                                    disabled
                                                >
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input
                                    type="number"
                                    class="form-control prazo"
                                    name="prazo[]"
                                    min="1"
                                    max="180"
                                    step="1"
                                    oninput="validity.valid || (value = '');"
                                    value="{{ $parcela->getPrazo() }}"
                                    readonly
                                    required
                                >
                            </td>
                            <td>
                                <input
                                    type="number"
                                    class="form-control porcentagem"
                                    name="porcentagem[]"
                                    min="0"
                                    max="100"
                                    value="{{ $parcela->getPorcentagem() }}"
                                    readonly
                                    required
                                >
                            </td>

                            <td class="text-center">
                                <div class="btn-group-sm py-1">
                                    <button
                                        type="button"
                                        class="btn btn-success add"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Adicionar"
                                        style="display: none"
                                    >
                                        <i class="fa fa-check"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-warning edit"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Editar"
                                    >
                                        <i class="fa fa-edit text-white"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-danger delete"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Remover"
                                    >
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>
</div>
