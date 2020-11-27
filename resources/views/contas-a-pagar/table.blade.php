<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table-conta">
        <thead>
            <tr>
                <th class="text-right">Documento</th>
                <th class="text-center">Parcela</th>
                <th class="text-center">Emissão</th>
                <th class="text-center">Vencimento</th>
                <th>Fornecedor</th>
                <th>Forma de Pagamento</th>
                <th class="text-right">Valor</th>
                <th class="text-center">Cancelado em</th>
                <th class="text-center">Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($contas as $conta)
            <tr>
                <td class="text-right">{{ $conta->getCompra()->getNumeroNota() }}</td>
                <td class="text-center">{{ $conta->getParcela() }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($conta->getCompra()->getDataEmissao())) }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($conta->getDataVencimento())) }}</td>
                <td>{{ $conta->getFornecedor()->getRazaoSocial() }}</td>
                <td>{{ $conta->getFormaPagamento()->getFormaPagamento() }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($conta->getValorParcela(), 2, ',', '.') }}</td>
                <td class="text-center">{{ $conta->getCompra()->getDataCancelamento() }}</td>
                <td class="text-center">
                    @php
                        $badge = '';
                        switch ($conta->getStatus()) {
                            case 'Em aberto':
                                $badge = 'badge-info';
                                break;
                            case 'Pago':
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
                <td class="text-center">
                    <div class="btn-group-xs">
                        @if ($conta->getStatus() == 'Em aberto')
                            <a
                                href="{{ route('contas-a-pagar.edit', $conta->getPrimaryKeyStr()) }}"
                                class="btn btn-success"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Pagar"
                            >
                                <i class="fa fa-check"></i>
                            </a>
                        @endif

                        <a
                            href="{{ route('contas-a-pagar.show', $conta->getPrimaryKeyStr()) }}"
                            class="btn btn-info"
                            data-toggle="tooltip"
                            data-placement="left"
                            title="Visualizar"
                        >
                            <i class="fa fa-eye"></i>
                        </a>

                        @if ($conta->getStatus() == 'Pago')
                            <a
                                href="{{ route('contas-a-pagar.edit', $conta->getPrimaryKeyStr()) }}"
                                class="btn btn-danger"
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
                <th class="text-right">Documento</th>
                <th class="text-center">Parcela</th>
                <th class="text-center">Emissão</th>
                <th class="text-center">Vencimento</th>
                <th>Fornecedor</th>
                <th>Forma de Pagamento</th>
                <th class="text-right">Valor</th>
                <th class="text-center">Cancelado em</th>
                <th class="text-center">Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
