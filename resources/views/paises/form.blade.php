<div class="card">
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
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($pais) ? $pais->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($pais) ? $pais->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('paises.actions')
