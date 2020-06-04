@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-plus"></i>
            <h3 class="ml-3 mb-0">Cadastrar Categoria</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($categoria)
            <form method="POST" action="{{ route('categorias.update', $categoria->id) }}">
                @method('PUT')
        @else
            <form method="POST" action="{{ route('categorias.store') }}">
        @endif

            @csrf
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label>Cód.</label>
                    <input type="text" id="id" name="id" class="form-control @error('id') @errror is-invalid @enderror"
                        value="{{ old('id', $categoria->id ?? null) }}" readonly disabled >

                    @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Categoria <span class="text-danger">*</span></label>
                    <input type="text" id="categoria" name="categoria" class="form-control @error('categoria') @errror is-invalid @enderror" value="{{ old('categoria', $categoria->categoria ?? null) }}" onkeyup="toUpper(this)" autofocus>

                    @error('categoria')
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
                    <a class="btn btn-secondary" href="{{ route('categorias.index') }}">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>
            </div>
        </form>

    </div>
</div>


@endsection
