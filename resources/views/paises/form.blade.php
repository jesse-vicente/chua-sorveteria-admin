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

                <div class="d-flex justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($pais) ? $pais->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($pais) ? $pais->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>

                        <a class="btn btn-outline-secondary" href="{{ route('paises.index') }}">
                            <span class="text-bold">Cancelar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>
