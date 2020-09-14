<div class="card col-xl-5 p-0">
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
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($cidade) ? $cidade->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($cidade) ? $cidade->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('cidades.actions')
        </div>
    </div>
</div>
