<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($carta, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('toggletipo', $toggletipo, array('id'=>'toggletipo')) !!}
	<div class="row ">
		<div class="col-sm form-group">
			{!! Form::label('fechainicial', 'Fecha Notificación', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechainicial', date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fechainicial' , 'readonly' => true)) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('fechalimite', 'Fecha Límite', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechalimite',null, array('class' => 'form-control  input-xs', 'id' => 'fechalimite')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('tipo_id', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo_id',$tipostramite, $inspeccion ? $inspeccion->tipo_id : null, array('class' => 'form-control  input-xs', 'id' => 'tipo_id' , 'onchange' => 'generarNumero();')) !!}
			</div>
		</div>		
	</div>
	<div class="row">
		<div class="col-3 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
		<div class="form-group col-3">
			{!! Form::label('plazo', 'Plazo (Días)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblplazo')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('plazo', null, array('class' => 'form-control  input-xs', 'id' => 'plazo')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			{!! Form::label('aviso', 'Tipo de Notificación*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="row  form-group ml-2">
				<div class="form-check form-check-inline">
					{{Form::radio('aviso', 'Notificacion', true , array("class"=>"form-check-input"))}}
					<label class="form-check-label" for="Notificacion">Notificacion Inicial</label>
				</div>
				<div class="form-check form-check-inline">
					{{Form::radio('aviso', 'Fin',false , array("class"=>"form-check-input"))}}
					<label class="form-check-label" for="Fin">Notificación de Fin de Proceso</label>
				</div>
			</div>			
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('asunto', 'Asunto*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('asunto', null, array('class' => 'form-control  input-xs', 'id' => 'asunto')) !!}
			</div>
		</div>
		@if (!is_null($inspeccion))
		{!! Form::hidden('inspeccion_id', $inspeccion->id, array('id'=>'inspeccion_id')) !!}
		@else
		<div class="col-sm form-group">
			{!! Form::label('inspeccion_idSelect', 'Nro.* Documento de Referencia', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('inspeccion_idSelect', $cboInspecciones, array('class' => 'form-control  input-xs', 'id' => 'inspeccion_idSelect')) !!}
			</div>
		</div>
		@endif
	</div>
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('destinatario', 'Destinatario*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('destinatario', $inspeccion ? $inspeccion->representante : null, array('class' => 'form-control  input-xs', 'id' => 'destinatario')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('razonsocial', 'Razon Social*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('razonsocial', $inspeccion ? $inspeccion->razonsocial : null, array('class' => 'form-control  input-xs', 'id' => 'razonsocial')) !!}
			</div>
		</div>	
	</div>
	<div class="form-group">
			{!! Form::label('direccion', 'Dirección*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('direccion', $inspeccion ? $inspeccion->direccion : null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
			</div>
	</div>
	<div class="form-group">
		{!! Form::label('cuerpo', 'Cuerpo del Documento*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<textarea name="cuerpo" id="cuerpo" class="form-control input-xs" cols="20" rows="10">
Mediante el presente le expreso mi cordial y afectuoso saludo, así como también informarle lo siguiente:
Que, visto el Exp. N° ..... de fecha ......., presentado por su persona en donde solicita .........
Sin otro particular quedo de Usted con las consideraciones y estima personal.
Atentamente;
		</textarea>
	</div>	
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'type'=>'submit')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {

	configurarAnchoModal('1000');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	
	var tipotogle = $('#toggletipo').val();
	showTipo(tipotogle);
	generarNumero();
	$('#inspeccion_idSelect').select2()


}); 
$( IDFORMMANTENIMIENTO + '{{ $entidad }}').submit(function( event ) {
			event.preventDefault();
			var idformulario = IDFORMMANTENIMIENTO + '{{ $entidad }}';
			var entidad = "{{$entidad2}}";
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
					if (respuesta.includes('id=?')) {
						cerrarModal();
						Hotel.notificaciones("Accion realizada correctamente", "Realizado" , "success");
						if (listar.trim() === 'SI') {							
							buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
						}
						var id = respuesta.trim();
						var matches = id.match(/(\d+)/);
						id=matches[0];
						window.open( 'carta/pdf/'+id , '_blank');
					} else {
						mostrarErrores(respuesta, idformulario, entidad);
					}
				}
			}); 
    	});

	function showTipo(tipo){
		console.log(tipo);
		switch (tipo) {
			case "1":
				$('#divSalubridad').removeClass('d-none');
				$('#divLicencias').removeClass('d-none');
				break;
			case "2":
				$('#divSalubridad').addClass('d-none');
				$('#divLicencias').addClass('d-none');
				break;
			case "3":
				$('#divSalubridad').removeClass('d-none');
				$('#divLicencias').addClass('d-none');
				break;
			case "4":
				$('#divSalubridad').addClass('d-none');
				$('#divLicencias').addClass('d-none');
				break;
			default:
				break;
		}
	}
	

	function generarNumero(){
		var tipo = $('#tipo_id').val();
		showTipo(tipo);
		$.ajax({
			type: "POST",
			url: "{{route('carta.generarnumero')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo_id"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
			}
		});
	}
</script>
