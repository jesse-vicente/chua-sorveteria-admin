<div id="mask"></div>

<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Data Venda</th>
                <th>Cliente</th>
                <th>Valor Total</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($vendas as $venda)
            <tr>
                <td>{{ $venda->getNumeroNota() }}</td>
                <td>{{ date('d/m/Y', strtotime($venda->getDataVenda())) }}</td>
                <td>{{ $venda->getCliente()->getNome() }}</td>
                <td>{{ 'R$ ' . number_format($venda->getTotalVenda(), 2) }}</td>
                <td>
                    @php
                        if ($venda->getStatus() == 'Ativo')
                            $badge = 'badge-success';
                        else if ($venda->getStatus() == 'Cancelado')
                            $badge = 'badge-danger';
                        else
                            $badge = 'badge-info';
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($venda->getStatus()) }}</span>
                </td>
                <td class="d-flex justify-content-center">
                    @if ($venda->getStatus() == 'Em aberto')
                        <a href="{{ route('vendas.cancel', $venda->getPrimaryKey()) }}" title="Cancelar Venda">
                            <i class="fa fa-2x fa-times-circle text-danger"></i>
                        </a>
                    @else
                        <!-- <a
                            href="{{ route('contas-a-pagar.show', $venda->getPrimaryKey()) }}"
                            class="btn btn-sm btn-info"
                            data-toggle="tooltip"
                            data-placement="left"
                            title="Visualizar"
                        >
                            <i class="fa fa-eye"></i>
                        </a> -->
                        -
                    @endif
                </td>
            </tr>
        @empty

        @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Documento</th>
                <th>Data Venda</th>
                <th>Cliente</th>
                <th>Valor Total</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
