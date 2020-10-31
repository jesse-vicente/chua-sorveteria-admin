<!-- <div class="card" id="card-duplicatas">
    <div class="card-header bg-gray-dark">
        <h3 class="card-title">
            <i class="fa fa-handshake mr-1"></i>
            Contas à Pagar
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>

    <div class="card-body p-0"> -->
        <table class="table table-sm table-striped table-responsive-xl table-bordered" id="duplicatas-table">
            @isset($compra)
                <thead>
                    <tr>
                        <th>Duplicata</th>
                        <th>Forma de Pagamento</th>
                        <th class="text-center">Vencimento</th>
                        <th class="text-right">Valor da Parcela</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($compra->getContasPagar() as $duplicata)
                    <tr>
                        <td>{{ $duplicata->getCompra()->getNumeroNota() . '/' . $duplicata->getParcela() }}</td>
                        <td>{{ $duplicata->getFormaPagamento()->getFormaPagamento() }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($duplicata->getDataVencimento())) }}</td>
                        <td class="text-right">{{ 'R$ ' . number_format($duplicata->getValorParcela(), 2, ',', '.') }}</td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            @endisset
        </table>
    <!-- </div>
</div> -->
