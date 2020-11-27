<div class="card col-xl-5 p-0 mx-auto">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($cidade)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Cidade</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Cidade</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($cidade)
            <form method="POST" action="{{ route('cidades.update', $cidade->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('cidades.store') }}">
        @endif

                @csrf
                @include('cidades.fields')

                <div class="d-flex justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                    <div class="d-flex flex-column justify-content-center text-secondary">
                        <small><b>Cadastrado em: </b>{{ isset($cidade) ? $cidade->getDataCadastro() : "__/__/____" }}</small>
                        <small><b>Alterado em: </b>{{ isset($cidade) ? $cidade->getDataAlteracao() : "__/__/____" }}</small>
                    </div>

                    <div class="btn-group-lg">
                        <button type="submit" class="btn btn-success mr-2">
                            <span class="text-bold">Salvar</span>
                        </button>

                        <a class="btn btn-outline-secondary" href="{{ route('cidades.index') }}">
                            <span class="text-bold">Cancelar</span>
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>

@include('estados.create-modal')
