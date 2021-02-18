<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalEditar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formEditar">
                    @csrf
                    <input type="hidden" id="numero_id" name="numero_id">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="descripcion2" class="control-label">{{ 'Nombre' }}</label>
                            <input class="form-control" required name="descripcion2" type="text" id="descripcion2">
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="link2" class="control-label">{{ 'Link' }}</label>
                            <input class="form-control" required name="link2" type="text" id="link2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="icono2" class="control-label">{{ 'Icono' }}</label>
                            <input class="form-control" name="icono2" type="text" id="icono2">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="orden2" class="control-label">{{ 'Orden' }}</label>
                            <input class="form-control" name="orden2" type="number" id="orden2">

                        </div>
                        <div class="form-group col-sm-4">
                            <label for="grupomenu_id2" class="control-label">{{ 'Grupo Menu' }}</label>
                            <select class="form-control" required name="grupomenu_id2" id="grupomenu_id2">
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
                        <button id="btnActualizar" class="btn btn-outline-success" type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>