
<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Forma de Pagamento</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($formasPagamento as $formaPagamento)
        <tr>
            <td>{{ $formaPagamento->getId() }}</td>
            <td>{{ $formaPagamento->getFormaPagamento() }}</td>
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
        </tr>
    @endforelse
    </tbody>
</table>
