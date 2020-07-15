<div class="card">
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
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($categoria) ? $categoria->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($categoria) ? $categoria->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('categorias.actions')
