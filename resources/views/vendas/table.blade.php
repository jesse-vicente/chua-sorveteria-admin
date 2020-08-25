<div class="table-responsive">
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Cliente</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($vendas as $venda)
            <tr>
                <td>{{ $venda->getId() }}</td>
                <td>{{ $venda->getCliente()->getNome() }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('vendas.edit', $venda->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('vendas.show', $venda->getId()) }}">
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
            </tr> -->
        @endforelse
        </tbody>
    </table>
</div>
