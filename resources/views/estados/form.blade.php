<div class="card col-xl-5 p-0 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($estado)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Estado</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Estado</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($estado)
            <form method="POST" action="{{ route('estados.update', $estado->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('estados.store') }}">
        @endif

                @csrf
                @include('estados.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($estado) ? $estado->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($estado) ? $estado->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('estados.actions')
        </div>
    </div>
</div>

@include('paises.create-modal')
