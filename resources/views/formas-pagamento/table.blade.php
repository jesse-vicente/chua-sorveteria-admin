<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Forma de Pagamento</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($formasPagamento as $formaPagamento)
        <tr>
            <td>{{ $formaPagamento->id }}</td>
            <td class="white-space">{{ $formaPagamento->formaPagamento }}</td>
            <td class="text-center">
                <div class="row no-gutters d-flex justify-content-center">
                    <a class="btn btn-sm btn-spinner btn-primary mr-2" href="{{ route('formas-pagamento.edit', $formaPagamento->id) }}">
                        <i class="fa fa-edit"></i>
                    </a>

                    <form action="{{ route('formas-pagamento.destroy', $formaPagamento->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <!-- <tr>
            <td colspan="8">
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle"></i>
                    Nenhum registro encontrado!
                </div>
            </td>
            <td class="d-none"></td>
            <td class="d-none"></td>
        </tr> -->
        @endforelse
        </tbody>
    </table>
</div>
