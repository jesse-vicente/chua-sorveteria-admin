@extends('adminlte::page')

@section('content')
<div class="card col-xl-7 p-0 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-trash-alt"></i>
            <h3 class="ml-3 mb-0">Excluir Funcionário</h3>
        </div>
    </div>

    <div class="card-body">
        @isset($funcionario)
        <form method="POST" action="{{ route('funcionarios.destroy', $funcionario->getId()) }}" id="form-show">
            @csrf
            @method('DELETE')

            @include('funcionarios.fields')
        </form>
        @endif
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($funcionario) ? $funcionario->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($funcionario) ? $funcionario->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            <div class="btn-group-lg">
                <button type="button" class="btn btn-danger mr-2" id="btn-delete">
                    <span class="text-bold">Excluir</span>
                </button>

                <a class="btn btn-outline-secondary" href="{{ route('funcionarios.index') }}">
                    <span class="text-bold">Cancelar</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
