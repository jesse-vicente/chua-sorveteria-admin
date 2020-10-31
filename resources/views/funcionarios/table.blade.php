<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Funcionário</th>
                <th>Telefone / WhatsApp</th>
                <th>Endereço</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($funcionarios as $funcionario)
            <tr>
                <td>{{ $funcionario->getId() }}</td>
                <td>{{ $funcionario->getNome() }}</td>
                <td>{{ $funcionario->getTelefonesContato() }}</td>
                <td>{{ $funcionario->getEndereco() . ', ' . $funcionario->getNumero() . ' - ' . $funcionario->getBairro() }}</td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a class="btn btn-primary" href="{{ route('funcionarios.edit', $funcionario->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" href="{{ route('funcionarios.show', $funcionario->getId()) }}">
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
                <th>Funcionário</th>
                <th>Telefone / WhatsApp</th>
                <th>Endereço</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
