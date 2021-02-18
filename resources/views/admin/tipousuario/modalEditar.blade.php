<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalEditar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Tipo de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formEditar">
                    @csrf
                    <input type="hidden" id="numero_id" name="numero_id">
                    <div class="form-group">
                        <label for="descripcion2" class="control-label">{{ 'Nombre' }}</label>
                        <input class="form-control" name="descripcion2" type="text" id="descripcion2">
                    </div>
                    <div class="form-group">
                        <button id="btnActualizar" class="btn btn-outline-success" type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>