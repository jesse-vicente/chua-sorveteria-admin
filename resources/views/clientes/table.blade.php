<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Cliente</th>
                <th>Telefone / WhatsApp</th>
                <th>Endereço</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->getId() }}</td>
                <td>{{ $cliente->getNome() }}</td>
                <td>{{ $cliente->getTelefonesContato() }}</td>
                <td>{{ $cliente->getEndereco() . ', ' . $cliente->getNumero() }}</td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a class="btn btn-primary" href="{{ route('clientes.edit', $cliente->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" href="{{ route('clientes.show', $cliente->getId()) }}">
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

        <tfoot>
            <th>Cód.</th>
            <th>Cliente</th>
            <th>Telefone / WhatsApp</th>
            <th>Endereço</th>
            <th class="text-center">Ações</th>
        </tfoot>
    </table>
</div>
