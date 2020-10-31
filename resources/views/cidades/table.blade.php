<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Cidade</th>
                <th>DDD</th>
                <th>Estado</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cidades as $cidade)
            <tr>
                <td>{{ $cidade->getId() }}</td>
                <td>{{ $cidade->getCidade() }}</td>
                <td>{{ $cidade->getDDD() }}</td>
                <td>{{ $cidade->getEstado()->getEstado() }}</td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a class="btn btn-primary" href="{{ route('cidades.edit', $cidade->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" href="{{ route('cidades.show', $cidade->getId()) }}">
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
                <th>Cidade</th>
                <th>DDD</th>
                <th>Estado</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
