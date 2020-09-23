@extends('adminlte::page')

@section('content')
<div class="card col-xl-5 p-0">
    <div class="card-header bg-danger">
        <div class="d-flex align-items-center">
            <i class="fa fa-trash-alt"></i>
            <h3 class="ml-3 mb-0">Excluir Categoria</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($categoria)
        <form method="POST" action="{{ route('categorias.destroy', $categoria->getId()) }}" id="form-delete">
            @csrf
            @method('DELETE')

            @include('categorias.fields')
        </form>
        @endif
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($categoria) ? $categoria->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($categoria) ? $categoria->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            <div class="btn-group-lg">
                <button type="button" class="btn btn-danger mr-2" id="btn-delete">
                    <span class="text-bold">Excluir</span>
                </button>

                <a class="btn btn-outline-secondary" href="{{ route('categorias.index') }}">
                    <span class="text-bold">Cancelar</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
