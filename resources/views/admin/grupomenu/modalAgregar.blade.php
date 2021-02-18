<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalAgregar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Grupo Menú</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formAgregar">
                    @csrf
                    <div class="form-group">
                        <label for="descripcion" class="control-label">{{ 'Nombre' }}</label>
                        <input class="form-control" name="descripcion" type="text" id="descripcion">
                    </div>

                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="icono" class="control-label">{{ 'Icono' }}</label>
                            <input class="form-control" name="icono" type="text" id="icono">
                        </div>
                        <div class="form-group col-sm">
                            <label for="orden" class="control-label">{{ 'Orden' }}</label>
                            <input class="form-control" name="orden" type="number" id="orden">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-success" type="submit">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>