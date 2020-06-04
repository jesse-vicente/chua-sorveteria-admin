<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Funcionário</th>
                <th>WhatsApp</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($funcionarios as $funcionario)
            <tr>
                <td>{{ $funcionario->id }}</td>
                <td>{{ $funcionario->funcionario }}</td>
                <td>{{ $funcionario->whatsapp }}</td>
                <td class="text-center">
                    <div class="row no-gutters d-flex justify-content-center">
                        <a class="btn btn-sm btn-spinner btn-primary mr-2" href="{{ route('funcionarios.edit', $funcionario->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST">
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
