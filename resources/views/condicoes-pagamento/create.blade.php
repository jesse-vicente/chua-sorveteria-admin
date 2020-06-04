@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Condição de Pagamento</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($condicaoPagamento)
            <form method="POST" action="{{ route('condicoes-pagamento.update', $condicaoPagamento->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('condicoes-pagamento.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $condicaoPagamento->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>Condição de Pagamento <span class="text-danger">*</span></label>
                    <input type="text" id="condicao_pagamento" name="condicao_pagamento" class="form-control @error('condicao_pagamento') @errror is-invalid @enderror" value="{{ old('condicaoPagamento', $condicaoPagamento->condicaoPagamento ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('condicaoPagamento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>Forma de Pagamento <span class="text-danger">*</span></label>

                    <select id="forma_pagamento_id" name="forma_pagamento_id" class="form-control selectSearch @error('forma_pagamento_id') @errror is-invalid @enderror" value="{{ old('forma_pagamento_id', $condicaoPagamento->forma_pagamento_id ?? null) }}">
                    </select>

                    @error('forma_pagamento_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Taxa Juros <span class="text-danger">*</span></label>
                    <input type="text" id="taxa_juros" name="taxa_juros" class="form-control @error('taxa_juros') @errror is-invalid @enderror" value="{{ old('taxa_juros', $condicaoPagamento->taxa_juros ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('taxa_juros')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Multa <span class="text-danger">*</span></label>
                    <input type="text" id="multa" name="multa" class="form-control @error('multa') @errror is-invalid @enderror" value="{{ old('multa', $condicaoPagamento->multa ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('multa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- <div class="table-responsive">
                <table class='table table-bordered table-hover' id="tab_logic">
                    <thead>
                        <tr class='info'>
                            <th>N º</th>
                            <th>Prazo</th>
                            <th>Taxa Juros</th>
                            <th>Porcentagem</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr id="addr0">
                            <td class="custom-tbl">
                                <input class='form-control input-sm' type="text" value="1" id="parcela_id[]" name="parcela_id[]" readonly required>
                            </td>
                            <td class="custom-tbl">
                                <input class='form-control input-sm' type="text" id="prazo[]" oninput='multiply(0);' name="prazo[]">
                            </td>
                            <td class="custom-tbl">
                                <input class='form-control input-sm' type="text" id="taxa_juros[]" name="taxa_juros[]">
                            </td>
                            <td class="custom-tbl">
                                <input class='form-control input-sm' type="text" id="porcentagem[]" name="porcentagem[]">
                            </td>
                            <td class="custom-tbl">
                                <i class="fa fa-trash-alt btn btn-danger"></i>
                            </td>
                        </tr>
                    </thead>
                    <tbody id="dynamic_field">

                    <tbody>
                    <tfoot>
                        <tr class='info'>
                            <td>Total de Parcelas
                                <input type='text' class='form-control input-sm' id='grand_total' name='grand_total' value='0' readonly required>
                            </td>
                    </tfoot>

                </table>
            </div> -->

            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h4>Parcelas</h4></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Adicionar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Prazo</th>
                            <th>Taxa Juros</th>
                            <th>Porcentagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="form-row mb-0">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Salvar
                    </button>
                    <a class="btn btn-secondary" href="{{ route('condicoes-pagamento.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>


@endsection
