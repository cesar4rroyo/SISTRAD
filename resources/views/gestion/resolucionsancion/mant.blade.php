<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($acta, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="row ">
		<div class="col-sm form-group">
			{!! Form::label('fecha', 'Fecha Inicio de Fiscalización*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::input('dateTime-local', 'fecha', null, array('class' => 'form-control  input-xs', 'id' => 'fecha')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('fechafin', 'Fecha Termino de Fiscalización*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::input('dateTime-local','fechafin',null, array('class' => 'form-control  input-xs', 'id' => 'fechafin')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('ordenanza', 'Ordenanza Muninicapl Nº*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('ordenanza', null, array('class' => 'form-control  input-xs', 'id' => 'ordenanza')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>		
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('subgerencia', 'Sub Gerencia*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('subgerencia', null, array('class' => 'form-control  input-xs', 'id' => 'subgerencia')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('fiscalizador', 'Fiscalizador*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('fiscalizador', null, array('class' => 'form-control  input-xs', 'id' => 'fiscalizador')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('dnifiscalizador', 'DNI Fiscalizador*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dnifiscalizador', null, array('class' => 'form-control  input-xs', 'id' => 'dnifiscalizador')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('participante', 'Participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('participante', null, array('class' => 'form-control  input-xs', 'id' => 'participante')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('condicionparticipante', 'Condición del participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('condicionparticipante', null, array('class' => 'form-control  input-xs', 'id' => 'condicionparticipante', 'placeholder'=>'Ej. Testigo, apoyo.')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('file', 'Archivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::file('file', null, array('class' => 'form-control-file  input-xs', 'id' => 'file' )) !!}
			</div>
	</div>
	</div>
	<div class="row">
		<div class="col-4 form-group">
			{!! Form::label('ruc', 'RUC', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
				<div class="col-lg-10 col-md-10 col-sm-10">
					{!! Form::text('ruc', null, array('class' => 'form-control  input-xs', 'id' => 'ruc')) !!}
				</div>
				<div class="col-lg-1 col-sm-1 col-md-1 pl-1">
					{!! Form::button('<i class="fa fa-search "></i>', array('class' => 'btn btn-primary', 'title' => 'Buscar RUC' , 'id' => 'botonBuscarRuc')) !!}
				</div>
			</div>
		</div>
		<div class="form-group col-8">
			{!! Form::label('direccion', 'Dirección*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('direccion', null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('razonsocial', 'Razon Social', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('razonsocial', null, array('class' => 'form-control  input-xs', 'id' => 'razonsocial')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('girocomercial', 'Giro Comercial', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('girocomercial', null, array('class' => 'form-control  input-xs', 'id' => 'girocomercial')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-6">
			{!! Form::label('representante', 'Representante*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('representante', null, array('class' => 'form-control  input-xs', 'id' => 'representante')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('dnirepresentante', 'DNI Representante*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dnirepresentante', null, array('class' => 'form-control  input-xs', 'id' => 'dnirepresentante')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('calidadrepresentante', 'Calidad Representante*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('calidadrepresentante', null, array('class' => 'form-control  input-xs', 'id' => 'calidadrepresentante')) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('ocurrencia', 'Hechos Materia de Verificación Y/U Ocurrencias de la Fiscalización*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('ocurrencia', null, array('class' => 'form-control  input-xs', 'id' => 'ocurrencia','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('observaciones', 'Manifestaciones u Observaciones', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observaciones', null, array('class' => 'form-control  input-xs', 'id' => 'observaciones','rows'=>3 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('conclusiones', 'Conclusiones del Acta del Fiscalizador', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12">
			<input type="checkbox" name="conclusiones[]" value="Certificación de conformidad">Certificación de conformidad <br/>
			<input type="checkbox" name="conclusiones[]" value=" Recomendación de mejoras">  Recomendación de mejoras <br/>
			<input type="checkbox" name="conclusiones[]" value="Advertencia de incumplimiento"> Advertencia de incumplimiento <br/>
			<input type="checkbox" name="conclusiones[]" value=" Recomendación de inicio de procedimiento sancionador">  Recomendación de inicio de procedimiento sancionador <br/>
			<input type="checkbox" name="conclusiones[]" value="Adopción de medidas provisionales"> Adopción de medidas provisionales <br/>
			<input type="checkbox" name="conclusiones[]" value="Clausura Inmediata"> Clausura Inmediata <br/>
			<input type="checkbox" name="conclusiones[]" value="Paralización Inmediata"> Paralización Inmediata <br/>
			<input type="checkbox" name="conclusiones[]" value="Cualquier mandato de hacer"> Cualquier mandato de hacer <br/>
			<input type="checkbox" name="conclusiones[]" value="Otros"> Otros <br/>
		</div>
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
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dnirepresentante"]').inputmask("99999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dnifiscalizador"]').inputmask("99999999");
	generarNumero();

	$('#botonBuscarRuc').on('click', function(){
		buscarRUC();
	});

	function buscarRUC(){
		var reg = new RegExp('^[0-9]+$');
		if($(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val() == ""){
			toastr.warning("Debe ingresar un RUC.", 'Error:');
		}else if(!reg.test($(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val())){
			toastr.warning("El RUC ingresado es incorrecto.", 'Error:');
		}else{
			$.ajax({
				type: "POST",
				url: "empresacourier/buscarRUC",
				data: "ruc="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val()+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
				beforeSend(){
				alert("Consultando...");
				},
				success: function(a) {
					datos=JSON.parse(a);
					if(datos.length == 0){
						toastr.warning("El RUC ingresado es incorrecto.", 'Error:');
					}else{
						$("#razonsocial").val(datos.RazonSocial);
						$("#direccion").val(datos.Direccion);
					}
				}
			});
		}
	}


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

	
	

	function generarNumero(){
		$.ajax({
			type: "POST",
			url: "{{route('acta.generarnumero')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo_id"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
			}
		});
	}
</script>
