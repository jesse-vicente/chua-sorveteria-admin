<div class="card" id="card-duplicatas">
    <div class="card-body p-0">
        <table class="table table-sm table-striped table-responsive-xl table-borderless border-right" id="duplicatas-table">
            @isset($venda)
                <thead>
                    <tr>
                        <th class="text-right">Parcela</th>
                        <th>Forma de Pagamento</th>
                        <th class="text-center">Vencimento</th>
                        <th class="text-right">Valor da Parcela</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($venda->getContasReceber() as $duplicata)
                        <tr>
                            <td class="text-right">{{ $duplicata->getVenda()->getNumeroNota() . '/' . $duplicata->getParcela() }}</td>
                            <td>{{ $duplicata->getFormaPagamento()->getFormaPagamento() }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($duplicata->getDataVencimento())) }}</td>
                            <td class="text-right">{{ 'R$ ' . number_format($duplicata->getValorParcela(), 2, ',', '.') }}</td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            @endisset
        </table>
    </div>
</div>
