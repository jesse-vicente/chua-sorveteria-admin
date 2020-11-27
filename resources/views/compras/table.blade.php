<div class="table-responsive">
    <table class="table table-hover table-striped shadow-xs rounded" id="table">
        <thead>
            <tr>
                <th>Núm. Nota</th>
                <th>Série</th>
                <th>Modelo</th>
                <th>Fornecedor</th>
                <th class="text-center">Data Emissão</th>
                <th class="text-right">Valor Total</th>
                <th class="text-center">Situação</th>
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
                <td class="text-center">{{ date('d/m/Y', strtotime($compra->getDataEmissao())) }}</td>
                <td class="text-right">{{ 'R$ ' . number_format($compra->getTotalCompra(), 2, ',', '.') }}</td>
                <td class="text-center">
                    @php
                        if ($compra->getStatus() == 'Ativo')
                            $badge = 'badge-success';
                        else if ($compra->getStatus() == 'Cancelado')
                            $badge = 'badge-danger';
                        else
                            $badge = 'badge-info';
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($compra->getStatus()) }}</span>
                </td>
                <td class="text-center">
                    <div class="btn-group-xs">
                        <a
                            href="{{ route('compras.show', $compra->getPrimaryKeyStr()) }}"
                            class="btn btn-info"
                            data-toggle="tooltip"
                            data-placement="left"
                            title="Visualizar"
                        >
                            <i class="fa fa-eye"></i>
                        </a>
                        @if ($compra->getStatus() == 'Emitido')
                            <a
                                href="{{ route('compras.cancel', $compra->getPrimaryKeyStr()) }}"
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
                <th>Núm. Nota</th>
                <th>Série</th>
                <th>Modelo</th>
                <th>Fornecedor</th>
                <th class="text-center">Data Emissão</th>
                <th class="text-right">Valor Total</th>
                <th class="text-center">Situação</th>
                <th class="text-center">Ações</th>
            </tr>
        </tfoot>
    </table>
</div>
