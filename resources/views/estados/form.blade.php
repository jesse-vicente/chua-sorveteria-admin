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

                <div class="d-flex justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($estado) ? $estado->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($estado) ? $estado->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>

                        <a class="btn btn-outline-secondary" href="{{ route('estados.index') }}">
                            <span class="text-bold">Cancelar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>

@include('paises.create-modal')
