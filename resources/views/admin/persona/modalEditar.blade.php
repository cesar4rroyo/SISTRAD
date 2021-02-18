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
                            <label for="apellidos2" class="control-label">{{ 'Apellidos' }}</label>
                            <input class="form-control" required name="apellidos2" type="text" id="apellidos2">
                        </div>
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
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="razonsocial2"
                                class="control-label">{{ 'Razón Social (Solo Clientes RUC)' }}</label>
                            <input class="form-control" name="razonsocial2" type="text" id="razonsocial2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="ruc2" class="control-label">{{ 'RUC' }}</label>
                            <span class="badge badge-primary" id="btnBuscarRuc">
                                <i class="fas fa-search"></i>
                                {{'Buscar'}}</span>
                            <input class="form-control" name="ruc2" type="number" id="ruc2">

                        </div>
                        <div class="form-group col-sm">
                            <label for="dni2" class="control-label">{{ 'DNI' }}</label>
                            <input class="form-control" name="dni2" type="text" id="dni2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="sexo2" class="control-label">{{ 'Sexo' }}</label>
                            <select name="sexo2" class="form-control" id="sexo2">
                                <option value="">
                                    Seleccione una opcion
                                </option>
                                <option value="femenino">Femenino</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="fechanacimiento2" class="control-label">{{ 'Fecha de nacimiento' }}</label>
                            <input class="form-control" name="fechanacimiento2" type="date" id="fechanacimiento2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="edad2" class="control-label">{{ 'Edad' }}</label>
                            <input class="form-control" name="edad2" type="number" id="edad2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="direccion2" class="control-label">{{ 'Dirección' }}</label>
                            <input class="form-control" name="direccion2" type="text" id="direccion2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="ciudad2" class="control-label">{{ 'Ciudad' }}</label>
                            <input class="form-control" name="ciudad2" type="text" id="ciudad2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="telefono2" class="control-label">{{ 'Teléfono' }}</label>
                            <input class="form-control" name="telefono2" type="text" id="telefono2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="email2" class="control-label">{{ 'Email' }}</label>
                            <input class="form-control" name="email2" type="text" id="email2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observacion2" class="control-label">{{ 'Observacion' }}</label>
                        <input class="form-control" name="observacion2" type="text" id="observacion2">
                    </div>
                    <div class="form-group">
                        <button id="btnActualizar" class="btn btn-outline-success" type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>