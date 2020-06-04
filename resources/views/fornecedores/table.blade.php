<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Fornecedor</th>
                <th>WhatsApp</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($fornecedores as $fornecedor)
            <tr>
                <td>{{ $fornecedor->id }}</td>
                <td>{{ $fornecedor->fornecedor }}</td>
                <td>{{ $fornecedor->whatsapp }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-spinner btn-primary mr-2" href="{{ route('fornecedores.edit', $fornecedor->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST">
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
            </tr> -->
        @endforelse
        </tbody>
    </table>
</div>
