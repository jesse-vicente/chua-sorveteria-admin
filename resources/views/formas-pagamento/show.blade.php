@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header bg-danger">
        <div class="d-flex align-items-center">
            <i class="fa fa-trash-alt"></i>
            <h3 class="ml-3 mb-0">Excluir Forma de Pagamento</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($formaPagamento)
        <form method="POST" action="{{ route('formas-pagamento.destroy', $formaPagamento->getId()) }}" id="form-delete">
            @csrf
            @method('DELETE')

            @include('formas-pagamento.fields')
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

    <a class="btn btn-outline-secondary" href="{{ route('formas-pagamento.index') }}">
        <span class="text-bold">Cancelar</span>
    </a>
</div>
@endsection
