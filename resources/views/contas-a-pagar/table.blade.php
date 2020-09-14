<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table-conta">
        <thead>
            <tr>
                <th style="width: 7%;">Documento</th>
                <th style="width: 6%;" class="text-center">Emissão</th>
                <th style="width: 7%;">Vencimento</th>
                <th>Fornecedor</th>
                <th>Forma de Pagamento</th>
                <th style="width: 5%;">Parcela</th>
                <th style="width: 8%;" class="text-right">Valor</th>
                <th style="width: 10.1%;">Dt. Cancelamento</th>
                <th style="width: 5%;" class="text-center">Status</th>
                <th style="width: 7%;" class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($contas as $conta)
            <tr>
                <td>{{ $conta->getCompra()->getNumeroNota() }}</td>
                <td>{{ date('d/m/Y', strtotime($conta->getCompra()->getDataEmissao())) }}</td>
                <td>{{ date('d/m/Y', strtotime($conta->getDataVencimento())) }}</td>
                <td>{{ $conta->getFornecedor()->getRazaoSocial() }}</td>
                <td>{{ $conta->getFormaPagamento()->getFormaPagamento() }}</td>
                <td class="text-center">{{ $conta->getParcela() }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($conta->getValorParcela(), 2) }}</td>
                <td class="text-center">{{ $conta->getCompra()->getDataCancelamento() }}</td>
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
                <td class="d-flex justify-content-center">
                    @if ($conta->getStatus() == 'Pendente')
                        <a href="{{ route('contas-a-pagar.edit', $conta->getPrimaryKey()) }}" class="btn btn-sm btn-success">
                            Pagar
                        </a>
                    @else
                        <!-- <a
                            href="{{ route('contas-a-pagar.show', $conta->getPrimaryKey()) }}"
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
                <th style="width: 6%;" class="text-center">Emissão</th>
                <th style="width: 7%;">Vencimento</th>
                <th>Fornecedor</th>
                <th>Forma de Pagamento</th>
                <th style="width: 5%;">Parcela</th>
                <th style="width: 8%;" class="text-right">Valor</th>
                <th style="width: 10.1%;">Dt. Cancelamento</th>
                <th style="width: 5%;" class="text-center">Status</th>
                <th style="width: 7%;" class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
