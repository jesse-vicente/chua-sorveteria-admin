<div class="table-responsive">
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Preço Venda</th>
                <th>Fornecedor</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produtos as $produto)
            <tr>
                <td>{{ $produto->getId() }}</td>
                <td>{{ $produto->getProduto() }}</td>
                <td>{{ $produto->getCategoria()->getCategoria() }}</td>
                <td>R$ {{ $produto->getPrecoVenda() }}</td>
                <td>{{ $produto->getFornecedor()->getRazaoSocial() }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('produtos.edit', $produto->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('produtos.show', $produto->getId()) }}">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <!-- <tr>
                <td colspan="8">
                    <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle"></i>
                        Nenhum registro encontrado!
                    </div>
                </td>
                <td class="d-none"></td>
                <td class="d-none"></td>
                <td class="d-none"></td>
                <td class="d-none"></td>
            </tr> -->
            @endforelse
        </tbody>
    </table>
</div>
