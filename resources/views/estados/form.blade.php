<div class="card col-xl-5 p-0">
    <div class="card-header">
        <div class="d-flex align-items-center">
            @isset($estado)
                <i class="fa fa-edit"></i>
                <h3 class="ml-3 mb-0">Alterar Estado</h3>
            @else
                <i class="fa fa-plus"></i>
                <h3 class="ml-3 mb-0">Cadastrar Estado</h3>
            @endif
        </div>
    </div>

    <div class="card-body">
        @isset($estado)
            <form method="POST" action="{{ route('estados.update', $estado->getId()) }}">
            @method('PUT')
        @else
            <form method="POST" action="{{ route('estados.store') }}">
        @endif

                @csrf
                @include('estados.fields')
            </form>
    </div>

    <div class="card-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column text-secondary">
                <small><b>Cadastrado em: </b>{{ isset($estado) ? $estado->getDataCadastro() : "__/__/____" }}</small>
                <small><b>Alterado em: </b>{{ isset($estado) ? $estado->getDataAlteracao() : "__/__/____" }}</small>
            </div>

            @include('estados.actions')
        </div>
    </div>
</div>

<div id="modal-paises-create" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2">
                <h3 class="modal-title">Cadastrar País</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('paises.save') }}">
                    @csrf
                    @include('paises.fields')
                </form>

                <div class="btn-group-lg">
                    <button type="submit" class="btn btn-success btn-save-modal mr-2">
                        <span class="text-bold">Salvar</span>
                    </button>
                    <a class="btn btn-outline-secondary" data-dismiss="modal">
                        <span class="text-bold">Cancelar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty(Session::get('success')))
<script>
    $(function() {
        $('#modal-paises').modal('show');
    });
</script>
@endif
