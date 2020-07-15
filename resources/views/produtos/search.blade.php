
<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Produto</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($produtos as $produto)
        <tr>
            <td>{{ $produto->id }}</td>
            <td>{{ $produtos->produto }}</td>
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
