<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Em Estoque</th>
                <th>Preço Venda</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produtos as $produto)
            <tr>
                <td>{{ $produto->getId() }}</td>
                <td>{{ $produto->getProduto() }}</td>
                <td>{{ $produto->getCategoria()->getCategoria() }}</td>
                <td>{{ $produto->getFornecedor()->getRazaoSocial() }}</td>
                <td>{{ $produto->getEstoque() ?? '-' }}</td>
                <td>R$ {{ $produto->getPrecoVenda() }}</td>
                <td class="text-center">
                    <div class="row flex-nowrap justify-content-center">
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
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Em Estoque</th>
                <th>Preço Venda</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
