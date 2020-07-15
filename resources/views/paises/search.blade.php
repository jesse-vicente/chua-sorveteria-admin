<table class="table table-hover" id="table">
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
            <td>{{ $pais->getId() }}</td>
            <td>{{ $pais->getPais() }}</td>
            <td>{{ $pais->getSigla() }}</td>
            <td>+{{ $pais->getDDI() }}</td>
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
