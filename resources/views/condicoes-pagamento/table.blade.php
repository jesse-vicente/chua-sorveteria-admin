<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Condição de Pagamento</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @isset($condicoesPagamento)
            @foreach ($condicoesPagamento as $condicaoPagamento)
            <tr>
                <td>{{ $condicaoPagamento->getId() }}</td>
                <td>{{ $condicaoPagamento->getCondicaoPagamento() }}</td>
                <td class="text-center">
                    <div class="row flex-nowrap justify-content-center">
                        <a class="btn btn-sm btn-primary mr-2" href="{{ route('condicoes-pagamento.edit', $condicaoPagamento->getId()) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-sm btn-danger" href="{{ route('condicoes-pagamento.show', $condicaoPagamento->getId()) }}">
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
