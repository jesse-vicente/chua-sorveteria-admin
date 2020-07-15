
<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Cidade</th>
            <th>DDD</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($cidades as $cidade)
        <tr>
            <td>{{ $cidade->getId() }}</td>
            <td>{{ $cidade->getCidade() }}</td>
            <td>{{ $cidade->getDDD() }}</td>
            <td>{{ $cidade->getEstado()->getEstado() }}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
