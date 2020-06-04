@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Produto</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($produto)
            <form method="POST" action="{{ route('produtos.update', $produto->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('produtos.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $produto->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Produto <span class="text-danger">*</span></label>
                    <input type="text" id="produto" name="produto" class="form-control @error('produto') @errror is-invalid @enderror" value="{{ old('produto', $produto->produto ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('produto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Unidade <span class="text-danger">*</span></label>
                    <input type="text" id="unidade" name="unidade" class="form-control @error('unidade') @errror is-invalid @enderror" value="{{ old('unidade', $produto->unidade ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('unidade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Fornecedor <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="fornecedor_id" value="{{ old('fornecedor_id', $produto->fornecedor_id ?? null) }}" />
                        <input class="form-control" name="fornecedor" value="{{ old('fornecedor', $produto->fornecedor ?? null) }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search" type="button" data-route="fornecedores" data-toggle="modal" data-target="#modal-fornecedores">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-fornecedores" class="modal fade" data-field="fornecedor" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary align-items-center py-2">
                                <h3 class="modal-title">Buscar Fornecedor</h3>
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
                <div class="form-group col-md-3">
                    <label>Categoria <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="categoria_id" value="{{ old('categoria_id', $produto->categoria_id ?? null) }}" />
                        <input class="form-control" name="categoria" value="{{ old('categoria', $produto->categoria ?? null) }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-search" type="button" data-route="categorias" data-toggle="modal" data-target="#modal-categorias">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="modal-categorias" class="modal fade" data-field="categoria" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary align-items-center py-2">
                                <h3 class="modal-title">Buscar Categoria</h3>
                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-1">
                    <label>Estoque Atual</label>
                    <input type="text" id="estoque" name="estoque" class="form-control @error('estoque') @errror is-invalid @enderror" value="{{ old('estoque', $produto->estoque ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('estoque')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Preço Custo <span class="text-danger">*</span></label>
                    <input type="text" id="preco_custo" name="preco_custo" class="form-control @error('preco_custo') @errror is-invalid @enderror" value="{{ old('preco_custo', $produto->preco_custo ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('preco_custo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-1">
                    <label>Preço Venda <span class="text-danger">*</span></label>
                    <input type="text" id="preco_venda" name="preco_venda" class="form-control @error('preco_venda') @errror is-invalid @enderror" value="{{ old('preco_venda', $produto->preco_venda ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('preco_venda')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Custo Últ. Compra <span class="text-danger">*</span></label>
                    <input type="text" id="custo_ultima_compra" name="custo_ultima_compra" class="form-control @error('custo_ultima_compra') @errror is-invalid @enderror" value="{{ old('custo_ultima_compra', $produto->custo_ultima_compra ?? null) }}" onkeyup="toUpper(this)" autofocus required>

                    @error('custo_ultima_compra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Data Últ. Compra</label>
                    <input type="date" id="data_ultima_compra" name="data_ultima_compra" class="form-control @error('data_ultima_compra') @errror is-invalid @enderror" value="{{ old('data_ultima_compra', $funcionario->data_ultima_compra ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('data_ultima_compra')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label>Data Últ. Venda</label>
                    <input type="date" id="data_ultima_venda" name="data_ultima_venda" class="form-control @error('data_ultima_venda') @errror is-invalid @enderror" value="{{ old('data_ultima_venda', $funcionario->data_ultima_venda ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('data_ultima_venda')
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
                        value="{{ old('data_cadastro', (isset($produto)) ? $produto->data_cadastro->format('Y-m-d') : date('Y-m-d')) }}"
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
                        value="{{ old('data_alteracao', (isset($produto)) ? $produto->data_alteracao->format('Y-m-d') : date('Y-m-d')) }}"
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
                    <a class="btn btn-secondary" href="{{ route('produtos.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>


@endsection
