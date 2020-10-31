<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>País</th>
                <th>Sigla</th>
                <th>DDI</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @if (isset($paises))
            @foreach ($paises as $pais)
            <tr>
                <td>{{ $pais->getId() }}</td>
                <td>{{ $pais->getPais() }}</td>
                <td>{{ $pais->getSigla() }}</td>
                <td>+{{ $pais->getDDI() }}</td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a class="btn btn-primary" href="{{ route('paises.edit',$pais->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" href="{{ route('paises.show', $pais->getId()) }}">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>

        <tfoot>
            <tr>
                <th>Cód.</th>
                <th>País</th>
                <th>Sigla</th>
                <th>DDI</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
