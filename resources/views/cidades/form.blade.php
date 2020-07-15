<div class="card">
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
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($cidade) ? $cidade->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($cidade) ? $cidade->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('cidades.actions')
