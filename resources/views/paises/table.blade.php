<div class="table-responsive">
    <table class="table table-hover" id="table">
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
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('paises.edit',$pais->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('paises.show', $pais->getId()) }}">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
