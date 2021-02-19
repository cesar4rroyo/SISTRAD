<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalPersonaEditar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formPersonaEditar">
                    @csrf
                    <input type="hidden" id="numeroPersona" name="numeroPersona">
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="nombres2" class="control-label">{{ 'Nombres' }}</label>
                            <input class="form-control" required name="nombres2" type="text" id="nombres2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="apellidopaterno2" class="control-label">{{ 'Apellido Paterno' }}</label>
                            <input class="form-control" required name="apellidopaterno2" type="text" id="apellidopaterno2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="apellidomaterno2" class="control-label">{{ 'Apellido Materno' }}</label>
                            <input class="form-control" required name="apellidomaterno2" type="text" id="apellidomaterno2">
                        </div>                        
                    </div>
                    <div class="row">                      
                        <div class="form-group col-sm">
                            <label for="dni2" class="control-label">{{ 'DNI' }}</label>
                            <input class="form-control" required name="dni2" type="text" id="dni2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="cargo_id2" class="control-label">{{ 'Cargo' }}</label>
                            <select name="cargo_id2" required class="form-control" id="cargo_id2">
                                <option value="">
                                    Seleccione una opcion
                                </option>
                                @foreach ($cargos as $item)
                                    <option value="{{$item['id']}}">{{$item['descripcion']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="area_id2" class="control-label">{{ 'Área' }}</label>
                            <select name="area_id2" required class="form-control" id="area_id2">
                                <option value="">
                                    Seleccione una opcion
                                </option>
                                @foreach ($areas as $item)
                                    <option value="{{$item['id']}}">{{$item['descripcion']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="rol_id2" class="control-label">{{ 'Roles' }}</label>
                            <select class="form-control select2 selectRol selectRolEditar" required id="rol_id2"
                                name="rol_id2[]" multiple="multiple" data-placeholder="Seleccionar rol"
                                style="width: 100%;">
                                @foreach ($roles as $id => $nombre)
                                <option value="{{$id}}"
                                    {{is_array(old('rol_id')) ? (in_array($id, old('rol_id')) ? 'selected' : '')  : (isset($persona) ? ($persona->roles->firstWhere('id', $id) ? 'selected' : '') : '')}}>
                                    {{$nombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="telefono2" class="control-label">{{ 'Teléfono' }}</label>
                            <input class="form-control" name="telefono2" type="text" id="telefono2">
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="form-group col-sm">
                            <label for="direccion2" class="control-label">{{ 'Dirección' }}</label>
                            <input class="form-control" name="direccion2" type="text" id="direccion2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="email2" class="control-label">{{ 'Email' }}</label>
                            <input class="form-control" name="email2" type="email" id="email2">
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