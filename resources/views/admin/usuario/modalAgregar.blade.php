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
                        <div class="form-group col-sm">
                            <label for="login" class="control-label">{{ 'Login' }}</label>
                            <input class="form-control" required name="login" type="text" id="login">
                        </div>
                        <div class="form-group col-sm">
                            <label for="password" class="control-label">{{ 'Password' }}</label>
                            <input class="form-control" required name="password" type="password" id="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="tipousuario" class="control-label">{{ 'Tipo Usuario' }}</label>
                            <select class="form-control" required name="tipousuario" id="tipousuario">
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
                            <label for="persona" class="control-label">{{ 'Persona' }}</label>
                            <select class="form-control" name="persona" id="persona">
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
                        <button class="btn btn-outline-success" type="submit">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>