

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($pretramite, $formData) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
    <div class="row">
        <div class="form-group col-sm">
            {!! Form::label('numero', 'Número', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('numero', $pretramite->numero, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'numero')) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('DNI', 'DNI', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('DNI', $pretramite->dni, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'DNI')) !!}
            </div>
        </div>	
    </div>
    <div class="form-group col-sm">
        {!! Form::label('remitente', 'Remitente', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('remitente', $pretramite->remitente, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'remitente')) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm">
            {!! Form::label('correo', 'Correo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('correo', $pretramite->correo, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'correo')) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('telefono', 'Telefono', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('telefono', $pretramite->telefono, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'telefono')) !!}
            </div>
        </div>	
    </div>
    <div class="row">
        <div class="form-group col-sm">
            {!! Form::label('asunto', 'Asunto', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::textarea('asunto', $pretramite->remitente, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'asunto' ,'style'=>'resize:none;','rows'=>'4')) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('comentario', 'Comentario', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::textarea('comentario', $pretramite->remitente, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'comentario' ,'style'=>'resize:none;','rows'=>'4')) !!}
            </div>
        </div> 
    </div>
    <label class="control-label px-2">Archivos</label>
    <table class="px-3 table table-bordered">
        <tr>
            <th>Archivo</th>
            <th>DESCRIPCION</th>
        </tr>
        @foreach ($pretramite->archivos as $archivo)
        <tr >
            <td>				
                <a href="{{asset('storage\archivos2\\'.$archivo->archivo)}}"  target="_blank" >ver archivo</a>
            </td>
            <td>{{$archivo->descripcion}}</td>
        </tr>
        @endforeach
    </table>
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-undo "></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal((contadorModal - 1));')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		configurarAnchoModal('1000');
        $('#dni').inputmask("99999999");
	});
</script>