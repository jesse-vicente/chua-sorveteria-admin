<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Núm. Nota</th>
                <th>Série</th>
                <th>Modelo</th>
                <th>Fornecedor</th>
                <th>Data Emissão</th>
                <th>Valor Total</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($compras as $compra)
            <tr>
                <td>{{ $compra->getNumeroNota() }}</td>
                <td>{{ $compra->getSerie() }}</td>
                <td>{{ $compra->getModelo() }}</td>
                <td>{{ $compra->getFornecedor()->getRazaoSocial() }}</td>
                <td>{{ date('d/m/Y', strtotime($compra->getDataEmissao())) }}</td>
                <td>{{ 'R$ ' . number_format($compra->getTotalCompra(), 2) }}</td>
                <td>
                    @php
                        $badge = $compra->getStatus() == 'Ativa' ? 'badge-success' : 'badge-danger';
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($compra->getStatus()) }}</span>
                </td>
                <td class="d-flex justify-content-center">
                    @if ($compra->getStatus() != 'Cancelado')
                        <a href="{{ route('compras.cancel', $compra->getPrimaryKey()) }}" title="Cancelar Compra">
                            <i class="fa fa-2x fa-times-circle text-danger"></i>
                        </a>
                    @else
                        <!-- <a
                            href="{{ route('contas-a-pagar.show', $compra->getPrimaryKey()) }}"
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
                <th>Núm. Nota</th>
                <th>Série</th>
                <th>Modelo</th>
                <th>Fornecedor</th>
                <th>Data Emissão</th>
                <th>Valor Total</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
