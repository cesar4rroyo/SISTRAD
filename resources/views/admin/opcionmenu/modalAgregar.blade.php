<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalAgregar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formAgregar">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="descripcion" class="control-label">{{ 'Nombre' }}</label>
                            <input class="form-control" required name="descripcion" type="text" id="descripcion">
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="link" class="control-label">{{ 'Link' }}</label>
                            <input class="form-control" required name="link" type="text" id="link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="icono" class="control-label">{{ 'Icono' }}</label>
                            <input class="form-control" name="icono" type="text" id="icono">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="orden" class="control-label">{{ 'Orden' }}</label>
                            <input class="form-control" name="orden" type="number" id="orden">

                        </div>
                        <div class="form-group col-sm-4">
                            <label for="grupomenu_id" class="control-label">{{ 'Grupo Menu' }}</label>
                            <select class="form-control" required name="grupomenu_id" id="grupomenu_id">
                                <option value="">
                                    Seleccione una opcion
                                </option>
                                @foreach ($grupomenu as $item)
                                <option value="{{$item['id']}}">
                                    {{$item['descripcion']}}
                                </option>
                                @endforeach
                            </select>
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