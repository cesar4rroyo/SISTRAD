<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($inspeccion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('toggletipo', $toggletipo, array('id'=>'toggletipo')) !!}
	<div class="row ">
		<div class="col-6 form-group">
			{!! Form::label('fecha', 'Fecha', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha', date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fecha')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			{!! Form::label('tipo_id', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo',$tipostramite, ($inspeccion)?$inspeccion->tipo_id:null, array('class' => 'form-control  input-xs', 'id' => 'tipo_id' , 'onchange' => 'generarNumero(); cambiarsubtipos();')) !!}
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-6 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
		
		<div class="col-6 form-group">
			{!! Form::label('ordenpago_id', 'Nro. Orden pago', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('ordenpago_id',$cboOrdenpago , null, array('class' => 'form-control  input-xs', 'id' => 'ordenpago_id')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		@if($inspeccion)
			<div class="col-9 form-group">
				{!! Form::label('subtipo', 'Subtipo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('subtipotramite',  $subtipos, $inspeccion->subtipo_id?$inspeccion->subtipo_id:'', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite' )) !!}
				</div>
			</div>
			@else
			<div class="col-9 form-group">
				{!! Form::label('subtipo', 'Subtipo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('subtipotramite',  ['' => '--Elije un subtipo'], null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite'  )) !!}
				</div>
			</div>
			@endif
	</div>
	<div class="d-none" id="divSalubridad">
		<div class="row">
			<div class="col-6 form-group">
				{!! Form::label('dni', 'DNI*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('dni', null, array('class' => 'form-control  input-xs', 'id' => 'dni')) !!}
				</div>
			</div>
			<div class="col-6 form-group">
				{!! Form::label('ruc', 'RUC*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
					<div class="col-lg-10 col-md-10 col-sm-10">
						{!! Form::text('ruc', null, array('class' => 'form-control  input-xs', 'id' => 'ruc')) !!}
					</div>
					<div class="col-lg-1 col-sm-1 col-md-1 pl-1">
						{!! Form::button('<i class="fa fa-search "></i>', array('class' => 'btn btn-primary', 'title' => 'Buscar RUC' , 'id' => 'botonBuscarRuc')) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm">
				{!! Form::label('representante', 'Representante del Negocio*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('representante', null, array('class' => 'form-control  input-xs', 'id' => 'representante')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('razonsocial', 'Razon Social*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('razonsocial', null, array('class' => 'form-control  input-xs', 'id' => 'razonsocial')) !!}
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="form-group col-sm">
				{!! Form::label('girocomercial', 'Giro Comercial*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('girocomercial', null, array('class' => 'form-control  input-xs', 'id' => 'girocomercial')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('direccion', 'Dirección*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('direccion', null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="row d-none" id="divLicencias">
		<div class="col-sm form-group">
			{!! Form::label('localidad', 'Localidad (Ubr.- PJ)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('localidad', null, array('class' => 'form-control  input-xs', 'id' => 'localidad')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('area', 'Área Construida o del Establecimiento(m2)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblarea')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('area', null, array('class' => 'form-control  input-xs', 'id' => 'area', 'step'=>'0.01')) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('descripcion', null, array('class' => 'form-control  input-xs', 'id' => 'descripcion','rows'=>2 , 'style' =>'resize:none;')) !!}	
	</div>
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('inspector', 'Inspector Designado*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('inspector',$cboInspector , null, array('class' => 'form-control  input-xs', 'id' => 'inspector')) !!}
			</div>
		</div>
	  	<div class="form-group col-sm">
				{!! Form::label('file', 'Archivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::file('file', null, array('class' => 'form-control-file  input-xs', 'id' => 'file' )) !!}
				</div>
		</div>
	</div>	
	<div class="form-group">
		{!! Form::label('conclusiones', 'Conclusiones*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('conclusiones', null, array('class' => 'form-control  input-xs', 'id' => 'conclusiones','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	@if (!$inspeccion)
		<div class="row">
			<div class="col-12 form-group">
				{!! Form::label('hasObservacion', 'La Inspección realizada, ¿presenta observaciones?*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="row  form-group ml-2">
					<div class="form-check form-check-inline">
						{{Form::radio('hasObservacion', 'Si',  false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="Si">Si</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('hasObservacion', 'No', true , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="No">No</label>
					</div>
				</div>			
			</div>
		</div>
	@else
	<div class="form-group">
		{!! Form::label('observacion', 'Observacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observacion', null, array('class' => 'form-control  input-xs', 'id' => 'observacion','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	@endif	
	<div class="form-group d-none" id="divObservacion">
		{!! Form::label('observacion', 'Observacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observacion', null, array('class' => 'form-control  input-xs', 'id' => 'observacion','rows'=>2 , 'style' =>'resize:none;')) !!}
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
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni"]').inputmask("99999999");
	$("input[name=hasObservacion]").change(function () {	
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
	
	var tipotogle = $('#toggletipo').val();
	showTipo(tipotogle);

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

	$('#ordenpago_id').on('change', function(){
		var value = $(this).val();
		$.ajax({
			type: 'POST',
			url: "{{route('inspeccion.getInfo')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&ordenpago_id="+value,
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="direccion"]').val(a.direccion);
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="representante"]').val(a.representante);
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="dni"]').val(a.dni_ruc);
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="ruc"]').val(a.dni_ruc);
				console.log(a.direccion);
				console.log(a);
			}

		});
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
		ordenpagoSelect2(tipo);
	}
	function ordenpagoSelect2(tipo){
		$('#ordenpago_id').select2({
			ajax: {
				delay: 250,
				url: '{{route('resolucion.listarOrdenpago')}}',
				data: function (params) {
					var query = {
						search: params.term,
						tipo: tipo,
					}
					return query;
				},
				placeholder: 'Nro. de Orden Pago',
				minimumInputLength: 1,
				processResults: function (res) {
					var datos = JSON.parse(res);
					return {
						results: datos.results
					};
				}
			}
		});
	}

	function generarNumero(){
		var tipo = $('#tipo_id').val();
		showTipo(tipo);
		$.ajax({
			type: "POST",
			url: "{{route('inspeccion.generarnumero')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
			}
		});
	}

	function cambiarsubtipos(){
	  var tipo_id =	$('#tipo_id').val();
	  if(tipo_id.length > 0){
		  $.ajax({
                url: "{{ route('ordenpago.listarsubtipos') }}",
                type: 'GET',
                data: { tipo_id },
                dataType: 'json',
                success: function (response) {
					var areaselect = $('#subtipotramite');
					areaselect.empty();
                    areaselect.append('<option value="">--Elije un subtipo</option>')
                    $.each(response.data, function (key, value) {
                        areaselect.append("<option value='" + value.id + "'>" + value.descripcion + "</option>");
                    });
                },
                error : function(){
                    alert('Hubo un error obteniendo las areas!');
                }
            });
	  }
	}
</script>
