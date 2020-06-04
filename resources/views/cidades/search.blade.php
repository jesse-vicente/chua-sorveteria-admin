
<table class="table table-hover">
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
            <td>{{ $cidade->id }}</td>
            <td class="white-space">{{ $cidade->cidade }}</td>
            <td>{{ $cidade->ddd }}</td>
            <td>{{ $cidade->estado }}</td>
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
