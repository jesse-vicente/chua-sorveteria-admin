
<table class="table table-hover">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>País</th>
            <th>Sigla</th>
            <th>DDI</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($paises as $pais)
        <tr>
            <td>{{ $pais->id }}</td>
            <td class="white-space">{{ $pais->pais }}</td>
            <td>{{ $pais->sigla }}</td>
            <td>{{ $pais->ddi }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8">
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle"></i>
                    Nenhum registro encontrado!
                </div>
            </td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
        </tr>
    @endforelse
    </tbody>
</table>
