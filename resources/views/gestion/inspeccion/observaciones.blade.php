<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($inspeccion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{{-- <div class="row">
		<div class="form-group col-sm">
			{!! Form::label('inspector2', 'Inspector Designado*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('inspector2', null, array('class' => 'form-control  input-xs', 'id' => 'inspector2')) !!}
			</div>
		</div>
	  	<div class="form-group col-sm">
				{!! Form::label('file2', 'Archivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::file('file2', null, array('class' => 'form-control-file  input-xs', 'id' => 'file2' )) !!}
				</div>
		</div>
	</div>	 --}}
	{!! Form::hidden('tipo', 'observacion', array('id'=>'tipo')) !!}
	{!! Form::hidden('numero', $inspeccion->numero, array('id'=>'numero')) !!}
	{!! Form::hidden('inspector', $inspeccion->inspector, array('id'=>'inspector')) !!}
	<div class="form-group">
		{!! Form::label('conclusiones2', 'Conclusiones*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('conclusiones2', null, array('class' => 'form-control  input-xs', 'id' => 'conclusiones2','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="row">
		<div class="col-12 form-group">
			{!! Form::label('hasObservacion2', 'La Inspección realizada, ¿presenta observaciones?*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="row  form-group ml-2">
				<div class="form-check form-check-inline">
					{{Form::radio('hasObservacion2', 'Si',  false , array("class"=>"form-check-input"))}}
					<label class="form-check-label" for="Si">Si</label>
				</div>
				<div class="form-check form-check-inline">
					{{Form::radio('hasObservacion2', 'No', true , array("class"=>"form-check-input"))}}
					<label class="form-check-label" for="No">No</label>
				</div>
			</div>			
		</div>
	</div>
	<div class="form-group d-none" id="divObservacion">
		{!! Form::label('observacion2', 'Observacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observacion2', null, array('class' => 'form-control  input-xs', 'id' => 'observacion2','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
		<p class="ml-1 text-danger">*El trámite se dará como finalizado</p>
	</div>
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'type' => 'submit')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {

	configurarAnchoModal('1000');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni"]').inputmask("99999999");
	$("input[name=hasObservacion2]").change(function () {	
		var valor = $(this).val(); 
		verificarObservacion(valor);
	});

	function verificarObservacion(valor){
		console.log(valor);
		if(valor == 'Si'){
			$('#divObservacion').removeClass('d-none');
		}else {
			$('#divObservacion').addClass('d-none');

		}
	}
	
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
				console.log('eeeee');
			}).fail(function(jqXHR, textStatus) {
				respuesta = 'ERROR';
			}).always(function(){
				if(respuesta.trim() === 'ERROR'){
				}else {
					if (respuesta.trim() === 'OK') {
						console.log('eeee');
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
	 
}); 
	
</script>
