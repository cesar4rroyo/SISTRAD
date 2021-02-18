<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalPersonaAgregar"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Nueva Persona</h5>
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
                            <label for="apellidos" class="control-label">{{ 'Apellidos' }}</label>
                            <input class="form-control" required name="apellidos" type="text" id="apellidos">
                        </div>
                        <div class="form-group col-sm">
                            <label for="rol_id[]" class="control-label">{{ 'Roles' }}</label>
                            <select class="form-control select2 selectRol" required id="rol_id[]" name="rol_id[]"
                                multiple="multiple" data-placeholder="Seleccionar rol" style="width: 100%;">
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
                            <label for="razonsocial"
                                class="control-label">{{ 'Razón Social (Solo Clientes RUC)' }}</label>
                            <input class="form-control" name="razonsocial" type="text" id="razonsocial">
                        </div>
                        <div class="form-group col-sm">
                            <label for="ruc" class="control-label">{{ 'RUC' }}</label>
                            <span class="badge badge-primary" id="btnBuscarRuc">
                                <i class="fas fa-search"></i>
                                {{'Buscar'}}</span>
                            <input class="form-control" name="ruc" type="number" id="ruc">

                        </div>
                        <div class="form-group col-sm">
                            <label for="dni" class="control-label">{{ 'DNI' }}</label>
                            <input class="form-control" name="dni" type="text" id="dni">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="sexo" class="control-label">{{ 'Sexo' }}</label>
                            <select name="sexo" class="form-control" id="sexo">
                                <option value="">
                                    Seleccione una opcion
                                </option>
                                <option value="femenino">Femenino</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="fechanacimiento" class="control-label">{{ 'Fecha de nacimiento' }}</label>
                            <input class="form-control" name="fechanacimiento" type="date" id="fechanacimiento">
                        </div>
                        <div class="form-group col-sm">
                            <label for="edad" class="control-label">{{ 'Edad' }}</label>
                            <input class="form-control" name="edad" type="number" id="edad">
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="form-group col-sm">
                            <label for="direccion" class="control-label">{{ 'Dirección' }}</label>
                            <input class="form-control" name="direccion" type="text" id="direccion">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="ciudad" class="control-label">{{ 'Ciudad' }}</label>
                            <input class="form-control" name="ciudad" type="text" id="ciudad">
                        </div>
                        <div class="form-group col-sm">
                            <label for="telefono" class="control-label">{{ 'Teléfono' }}</label>
                            <input class="form-control" name="telefono" type="text" id="telefono">
                        </div>
                        <div class="form-group col-sm">
                            <label for="email" class="control-label">{{ 'Email' }}</label>
                            <input class="form-control" name="email" type="text" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observacion" class="control-label">{{ 'Observacion' }}</label>
                        <input class="form-control" name="observacion" type="text" id="observacion">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-success" type="submit">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>