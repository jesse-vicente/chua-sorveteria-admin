<div id="mask"></div>

<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th class="text-right" style="width: 8%;">Documento</th>
                <th class="text-center" style="width: 8%;">Data Venda</th>
                <th>Cliente</th>
                <th class="text-right" style="width: 8%;">Valor Total</th>
                <th class="text-center" style="width: 8%;">Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($vendas as $venda)
            <tr>
                <td class="text-right">{{ $venda->getNumeroNota() }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($venda->getDataVenda())) }}</td>
                <td>{{ $venda->getCliente() ? $venda->getCliente()->getNome() : '-' }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($venda->getTotalVenda(), 2, ',', '.') }}</td>
                <td class="text-center">
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
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a
                            href="{{ route('vendas.show', $venda->getPrimaryKeyStr()) }}"
                            class="btn btn-sm btn-info"
                            data-toggle="tooltip"
                            data-placement="left"
                            title="Visualizar"
                        >
                            <i class="fa fa-eye"></i>
                        </a>
                        @if ($venda->getStatus() == 'Emitido')
                            <a
                                href="{{ route('vendas.cancel', $venda->getPrimaryKeyStr()) }}"
                                class="btn btn-danger btn-sm"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Cancelar"
                            >
                                <i class="fa fa-ban"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty

        @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" style="width: 8%;">Documento</th>
                <th class="text-center" style="width: 8%;">Data Venda</th>
                <th>Cliente</th>
                <th class="text-right" style="width: 8%;">Valor Total</th>
                <th class="text-center" style="width: 8%;">Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
