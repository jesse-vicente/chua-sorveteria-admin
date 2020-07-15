<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($fornecedor)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Fornecedor</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Fornecedor</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($fornecedor)
            <form method="POST" action="{{ route('fornecedores.update', $fornecedor->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('fornecedores.store') }}">
        @endif

            @csrf
            @include('fornecedores.fields')
            </form>
    </div>
</div>

<div class="d-flex justify-content-end flex-column align-items-xl-end mb-3">
    <small><b>Cadastrado em: </b>{{ isset($fornecedor) ? $fornecedor->getDataCadastro() : "__/__/____" }}</small>
    <small><b>Alterado em: </b>{{ isset($fornecedor) ? $fornecedor->getDataAlteracao() : "__/__/____" }}</small>
</div>

@include('fornecedores.actions')
