@extends('adminlte::page')

@section('content')
<div class="col-xl-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <i class="fa fa-eye"></i>
                <h3 class="ml-3 mb-0">Visualizar Conta a Pagar</h3>
            </div>
        </div>

        <div class="card-body">
            @isset($contaPagar)
                <form method="POST" id="form-show" action="{{ route('contas-a-pagar.update', $contaPagar->getPrimaryKeyStr()) }}">
                    @method('PUT')
                    @csrf
                    @include('contas-a-pagar.fields')

                    <div class="d-flex align-items-center justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                        <div class="d-flex flex-column text-secondary">
                            <small><b>Cadastrado em: </b>{{ isset($contaPagar) ? $contaPagar->getDataCadastro() : "__/__/____" }}</small>
                            <small><b>Alterado em: </b>{{ isset($contaPagar) ? $contaPagar->getDataAlteracao() : "__/__/____" }}</small>
                        </div>

                        <div class="btn-group-lg">
                            <a class="btn btn-outline-secondary" href="{{ route('contas-a-pagar.index') }}">
                                <span class="text-bold">Voltar</span>
                            </a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
