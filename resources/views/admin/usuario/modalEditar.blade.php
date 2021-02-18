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
                        <div class="form-group col-sm">
                            <label for="login2" class="control-label">{{ 'Login' }}</label>
                            <input class="form-control" required name="login2" type="text" id="login2">
                        </div>
                        <div class="form-group col-sm">
                            <label for="password2" class="control-label">{{ 'Password' }}</label>
                            <input class="form-control" required name="password2" type="password" id="password2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="tipousuario_id2" class="control-label">{{ 'Tipo Usuario' }}</label>
                            <select class="form-control" required name="tipousuario_id2" id="tipousuario_id2">
                                <option value="">
                                    {{'Seleccione una opcion'}}
                                </option>
                                @foreach ($tipousuarios as $item)
                                <option value="{{$item['id']}}">
                                    {{$item['descripcion']}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="persona_id2" class="control-label">{{ 'Persona' }}</label>
                            <select class="form-control" name="persona_id2" id="persona_id2">
                                <option value="">
                                    {{'Seleccione una opcion'}}
                                </option>
                                @foreach ($personas as $item)
                                <option value="{{$item['id']}}">
                                    {{$item['nombres']}}
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