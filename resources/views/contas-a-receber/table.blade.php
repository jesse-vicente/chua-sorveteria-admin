<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table-conta">
        <thead>
            <tr>
                <th style="width: 7%;">Documento</th>
                <th class="text-center">Parcela</th>
                <th class="text-center">Data Venda</th>
                <th class="text-center">Vencimento</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th class="text-right">Valor Total</th>
                <th class="text-center">Dt. Cancelamento</th>
                <th>Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($contas as $conta)
            <tr>
                <td class="text-right">{{ $conta->getVenda()->getNumeroNota() }}</td>
                <td class="text-center">{{ $conta->getParcela() }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($conta->getVenda()->getDataVenda())) }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($conta->getDataVencimento())) }}</td>
                <td>{{ $conta->getCliente()->getNome() }}</td>
                <td>{{ $conta->getFormaPagamento()->getFormaPagamento() }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($conta->getValorParcela(), 2) }}</td>
                <td class="text-center">{{ $conta->getVenda()->getDataCancelamento() }}</td>
                <td>
                    @php
                        $badge = '';
                        switch ($conta->getStatus()) {
                            case 'Pendente':
                                $badge = 'badge-warning';
                                break;
                            case 'Liquidado':
                                $badge = 'badge-success';
                                break;
                            case 'Cancelado':
                            default:
                                $badge = 'badge-danger';
                                break;
                        }
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($conta->getStatus()) }}</span>
                </td>
                <td>
                    @if ($conta->getStatus() == 'Pendente')
                        <a href="{{ route('contas-a-receber.edit', $conta->getPrimaryKey()) }}" class="btn btn-sm btn-success">
                            Finalizar
                        </a>
                    @else
                        <!-- <a
                            href="{{ route('contas-a-receber.show', $conta->getPrimaryKey()) }}"
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
                <th style="width: 7%;">Documento</th>
                <th class="text-center">Parcela</th>
                <th class="text-center">Data Venda</th>
                <th class="text-center">Vencimento</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th class="text-right">Valor Total</th>
                <th class="text-center">Dt. Cancelamento</th>
                <th>Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
