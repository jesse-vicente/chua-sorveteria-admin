<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Categoria</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($categorias as $categoria)
        <tr>
            <td>{{ $categoria->getId() }}</td>
            <td>{{ $categoria->getCategoria() }}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
