<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Categoria</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categorias as $categoria)
            <tr>
                <td>{{ $categoria->getId() }}</td>
                <td>{{ $categoria->getCategoria() }}</td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a class="btn btn-primary" href="{{ route('categorias.edit', $categoria->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" href="{{ route('categorias.show', $categoria->getId()) }}">
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
                <th>Categoria</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
