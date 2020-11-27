<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th class="text-center">Und.</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th class="text-center">Estoque</th>
                <th class="text-right">Preço Venda</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produtos as $produto)
            <tr>
                <td>{{ $produto->getId() }}</td>
                <td>{{ $produto->getProduto() }}</td>
                <td class="text-center">{{ $produto->getUnidade() }}</td>
                <td>{{ $produto->getCategoria()->getCategoria() }}</td>
                <td>{{ $produto->getFornecedor()->getRazaoSocial() }}</td>
                <td class="text-center">{{
                    $produto->getUnidade() != 'KG'
                        ? intval($produto->getEstoque())
                        : number_format($produto->getEstoque(), 2, ',', '.') . ' Kg'
                }}
                </td>
                <td class="text-right">R$ {{ number_format($produto->getPrecoVenda(), 2, ',', '.') }}</td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a class="btn btn-primary" href="{{ route('produtos.edit', $produto->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" href="{{ route('produtos.show', $produto->getId()) }}">
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
                <th class="text-center">Und.</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th class="text-center">Estoque</th>
                <th class="text-right">Preço Venda</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
