<div class="col-xl-5 mx-auto">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                @isset($produto)
                    <i class="fa fa-edit"></i>
                    <h3 class="ml-3 mb-0">Alterar Produto</h3>
                @else
                    <i class="fa fa-plus"></i>
                    <h3 class="ml-3 mb-0">Cadastrar Produto</h3>
                @endif
            </div>
        </div>

        <div class="card-body">
            @isset($produto)
                <form method="POST" action="{{ route('produtos.update', $produto->getId()) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('produtos.store') }}">
            @endif

                    @csrf
                    @include('produtos.fields')

                    <div class="d-flex justify-content-between border-top mt-2" style="padding-top: 1.25rem !important">
                        <div class="d-flex flex-column justify-content-center text-secondary">
                            <small><b>Cadastrado em: </b>{{ isset($produto) ? $produto->getDataCadastro() : "__/__/____" }}</small>
                            <small><b>Alterado em: </b>{{ isset($produto) ? $produto->getDataAlteracao() : "__/__/____" }}</small>
                        </div>

                        <div class="btn-group-lg">
                            <button type="submit" class="btn btn-success mr-2">
                                <span class="text-bold">Salvar</span>
                            </button>

                            <a class="btn btn-outline-secondary" href="{{ route('produtos.index') }}">
                                <span class="text-bold">Cancelar</span>
                            </a>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

@include('categorias.create-modal')
@include('fornecedores.create-modal')
