
<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Condição de Pagamento</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($condicoesPagamento as $condicaoPagamento)
        <tr>
            <td>{{ $condicaoPagamento->getId() }}</td>
            <td>{{ $condicaoPagamento->getCondicaoPagamento() }}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
