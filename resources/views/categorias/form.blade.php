<div class="card col-xl-5 p-0">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($categoria)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Categoria</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Categoria</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($categoria)
            <form method="POST" action="{{ route('categorias.update', $categoria->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('categorias.store') }}">
        @endif

            @csrf
            @include('categorias.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($categoria) ? $categoria->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($categoria) ? $categoria->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('categorias.actions')
        </div>
    </div>
</div>
