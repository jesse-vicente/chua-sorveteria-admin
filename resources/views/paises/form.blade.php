<div class="card col-xl-5 p-0 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($pais)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar País</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar País</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($pais)
            <form method="POST" action="{{ route('paises.update', $pais->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('paises.store') }}">
        @endif

            @csrf
            @include('paises.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($pais) ? $pais->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($pais) ? $pais->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('paises.actions')
        </div>
    </div>
</div>
