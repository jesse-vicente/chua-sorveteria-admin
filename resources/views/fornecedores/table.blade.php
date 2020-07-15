<div class="table-responsive">
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Fornecedor</th>
                <th>WhatsApp</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($fornecedores as $fornecedor)
            <tr>
                <td>{{ $fornecedor->getId() }}</td>
                <td>{{ $fornecedor->getRazaoSocial() }}</td>
                <td>{{ $fornecedor->getWhatsapp() }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
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
