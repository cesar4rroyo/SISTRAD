<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($modelo, $formData) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
    {!! Form::label('descargo', 'Descargo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::textarea('descargo', $modelo->descargo, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'descargo','rows'=>10 , 'style' =>'resize:none;')) !!}
    </div>

	
</div>
<div class="form-group">
	{!! Form::label('file', 'Archivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::file('file', null, array('class' => 'form-control-file  input-xs', 'id' => 'file' )) !!}
	</div>
</div>
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check "></i> '.$boton, array('class' => 'btn btn-primary btn-sm', 'id' => 'btnGuardar', 'type' => 'submit')) !!}
		{!! Form::button('<i class="fa fa-undo "></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal((contadorModal - 1));')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		configurarAnchoModal('800');
	});

	$( IDFORMMANTENIMIENTO + '{{ $entidad }}').submit(function( event ) {
			event.preventDefault();
			var idformulario = IDFORMMANTENIMIENTO + '{{ $entidad }}';
			var entidad = "{{$entidad}}";
			var formData = new FormData($(this)[0]);
			var respuesta = '';
			var listar       = 'NO';
			if ($(idformulario + ' :input[id = "listar"]').length) {
				var listar = $(idformulario + ' :input[id = "listar"]').val();
			};
			var request = $.ajax({
			url     : $(this).attr('action'),
			method  : "POST",
			data    : formData,
			processData: false,  
			contentType: false,
			});
			request.done(function(msg) {
				respuesta = msg;
			}).fail(function(jqXHR, textStatus) {
				respuesta = 'ERROR';
			}).always(function(){
				if(respuesta.trim() === 'ERROR'){
				}else {
					if (respuesta.trim() === 'OK') {
						cerrarModal();
						Hotel.notificaciones("Accion realizada correctamente", "Realizado" , "success");
						if (listar.trim() === 'SI') {							
							buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
						}        
					} else {
						mostrarErrores(respuesta, idformulario, entidad);
					}
				}
			}); 
    	}); 
</script>