<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Forma de Pagamento</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($formasPagamento as $formaPagamento)
        <tr>
            <td>{{ $formaPagamento->getId() }}</td>
            <td>{{ $formaPagamento->getFormaPagamento() }}</td>
            <td class="text-center">
                <div class="btn-group-xs">
                    <a class="btn btn-primary" href="{{ route('formas-pagamento.edit', $formaPagamento->getId()) }}">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a class="btn btn-danger" href="{{ route('formas-pagamento.show', $formaPagamento->getId()) }}">
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
                <th>Forma de Pagamento</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
