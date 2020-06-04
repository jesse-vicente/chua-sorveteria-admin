<div class="table-responsive">
    <table class="table table-hover">
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
                <td>{{ $pais->id }}</td>
                <td class="white-space">{{ $pais->pais }}</td>
                <td>{{ $pais->sigla }}</td>
                <td>{{ $pais->ddi }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-spinner btn-primary mr-2" href="{{ route('paises.edit',$pais->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('paises.destroy',$pais->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
