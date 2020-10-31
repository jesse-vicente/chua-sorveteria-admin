<div id="modal-paises-create" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header align-items-center py-2 bg-dark">
                <h3 class="modal-title">Cadastrar País</h3>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('paises.save') }}" data-route="paises">
                    @csrf
                    @include('paises.fields')
                </form>

                <div class="btn-group-lg d-flex justify-content-end">
                    <button class="btn btn-success btn-save-modal mr-2">
                        <span class="text-bold">Salvar</span>
                    </button>
                    <button class="btn btn-outline-secondary" data-dismiss="modal">
                        <span class="text-bold">Cancelar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
