
<table class="table table-hover">
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
            <td>{{ $estado->id }}</td>
            <td class="white-space">{{ $estado->estado }}</td>
            <td>{{ $estado->uf }}</td>
            <td>{{ $estado->pais_id }}</td>
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
