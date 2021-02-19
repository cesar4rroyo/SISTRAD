<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalPersonaAgregar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formPersona">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="nombres" class="control-label">{{ 'Nombres' }}</label>
                            <input class="form-control" required name="nombres" type="text" id="nombres">
                        </div>
                        <div class="form-group col-sm">
                            <label for="apellidopaterno" class="control-label">{{ 'Apellido Paterno' }}</label>
                            <input class="form-control" required name="apellidopaterno" type="text" id="apellidopaterno">
                        </div>
                        <div class="form-group col-sm">
                            <label for="apellidomaterno" class="control-label">{{ 'Apellido Materno' }}</label>
                            <input class="form-control" required name="apellidomaterno" type="text" id="apellidomaterno">
                        </div>                        
                    </div>
                    <div class="row">                      
                        <div class="form-group col-sm">
                            <label for="dni" class="control-label">{{ 'DNI' }}</label>
                            <input class="form-control" required name="dni" type="text" id="dni">
                        </div>
                        <div class="form-group col-sm">
                            <label for="cargo_id" class="control-label">{{ 'Cargo' }}</label>
                            <select name="cargo_id" required class="form-control" id="cargo_id">
                                <option value="">
                                    Seleccione una opcion
                                </option>
                                @foreach ($cargos as $item)
                                    <option value="{{$item['id']}}">{{$item['descripcion']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="area_id" class="control-label">{{ 'Área' }}</label>
                            <select name="area_id" required class="form-control" id="area_id">
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
                            <label for="rol_id" class="control-label">{{ 'Roles' }}</label>
                            <select class="form-control select2 selectRol selectRolEditar" required id="rol_id"
                                name="rol_id[]" multiple="multiple" data-placeholder="Seleccionar rol"
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
                            <label for="telefono" class="control-label">{{ 'Teléfono' }}</label>
                            <input class="form-control" name="telefono" type="text" id="telefono">
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="form-group col-sm">
                            <label for="direccion" class="control-label">{{ 'Dirección' }}</label>
                            <input class="form-control" name="direccion" type="text" id="direccion">
                        </div>
                        <div class="form-group col-sm">
                            <label for="email" class="control-label">{{ 'Email' }}</label>
                            <input class="form-control" name="email" type="email" id="email">
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