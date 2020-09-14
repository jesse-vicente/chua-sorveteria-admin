<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table" data-route="fornecedores">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Fornecedor</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($fornecedores as $fornecedor)
            <tr>
                <td>{{ $fornecedor->getId() }}</td>
                <td>{{ $fornecedor->getRazaoSocial() }}</td>
                <td>{{ $fornecedor->getTelefonesContato() }}</td>
                <td>{{ $fornecedor->getEndereco() . ', ' . $fornecedor->getNumero() }}</td>
                <td class="text-center">
                    <div class="row flex-nowrap justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('fornecedores.edit', $fornecedor->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('fornecedores.show', $fornecedor->getId()) }}">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty

        @endforelse
        </tbody>
    </table>
</div>
