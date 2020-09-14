@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header bg-danger">
        <div class="d-flex align-items-center">
            <i class="fa fa-trash-alt"></i>
            <h3 class="ml-3 mb-0">Excluir Fornecedor</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($fornecedor)
        <form method="POST" action="{{ route('fornecedores.destroy', $fornecedor->getId()) }}" id="form-delete">
            @csrf
            @method('DELETE')

            @include('fornecedores.fields')
        </form>

        @else
        <span>Registro não encontrado.</span>
        @endif
    </div>
</div>

<div class="btn-group-lg">
    <button type="button" class="btn btn-danger mr-2" id="delete-entry">
        <span class="text-bold">Excluir</span>
    </button>

    <a class="btn btn-outline-secondary" href="{{ route('fornecedores.index') }}">
        <span class="text-bold">Cancelar</span>
    </a>
</div>
@endsection
