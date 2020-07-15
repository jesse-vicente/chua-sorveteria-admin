
<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Estado</th>
            <th>UF</th>
            <th>País</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($estados as $estado)
        <tr>
            <td>{{ $estado->getId() }}</td>
            <td>{{ $estado->getEstado() }}</td>
            <td>{{ $estado->getUF() }}</td>
            <td>{{ $estado->getPais()->getPais() }}</td>
        </tr>
    @empty
        <!-- <tr>
            <td colspan="8">
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle"></i>
                    Nenhum registro encontrado!
                </div>
            </td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
        </tr> -->
    @endforelse
    </tbody>
</table>
