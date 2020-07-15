<div class="table-responsive">
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Estado</th>
                <th>UF</th>
                <th>País</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($estados as $estado)
            <tr>
                <td>{{ $estado->getId() }}</td>
                <td>{{ $estado->getEstado() }}</td>
                <td>{{ $estado->getUf() }}</td>
                <td>{{ $estado->getPais()->getPais() }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('estados.edit', $estado->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('estados.show', $estado->getId()) }}">
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
