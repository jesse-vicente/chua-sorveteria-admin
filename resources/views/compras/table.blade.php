<div class="table-responsive">
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Fornecedor</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($compras as $compra)
            <tr>
                <td>{{ $compra->getId() }}</td>
                <td>{{ $compra->getFornecedor()->getRazaoSocial() }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('compras.edit', $compra->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('compras.show', $compra->getId()) }}">
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
