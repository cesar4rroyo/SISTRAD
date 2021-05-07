<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($solicitud, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('toggletipo', $toggletipo, array('id'=>'toggletipo')) !!}
	<div class="row ">
		<div class="col-3 form-group">
			{!! Form::label('fecha', 'Fecha', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha', date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fecha' , 'readonly' => true)) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero', 'readonly'=>'true')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			{!! Form::label('tipo_id', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo',$tipostramite, null, array('class' => 'form-control  input-xs', 'id' => 'tipo_id' , 'onchange' => 'generarNumero();')) !!}
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-5 form-group">
			{!! Form::label('contribuyente', 'Contribuyente*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('contribuyente', null, array('class' => 'form-control  input-xs', 'id' => 'contribuyente')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('dni', 'DNI*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dni', null, array('class' => 'form-control  input-xs', 'id' => 'dni')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('ordenpago_id', 'Nro. Orden pago', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('ordenpago_id',$cboOrdenpago , null, array('class' => 'form-control  input-xs', 'id' => 'ordenpago_id')) !!}
			</div>
		</div>
	</div>
	<div class="row">			
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
		<div class="form-group col-6">
			{!! Form::label('razonsocial', 'Razon Social*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('razonsocial', null, array('class' => 'form-control  input-xs', 'id' => 'razonsocial')) !!}
			</div>
		</div>
	</div>
	<div class="d-none" id="divSalubridad">
		<div class="row">
			<div class="col-4 form-group">
				{!! Form::label('solicito', 'Tipo de Solicitud*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="row  form-group ml-2">
					<div class="form-check form-check-inline">
						{{Form::radio('solicito', 'Apertura', true , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="Apertura">Apertura</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('solicito', 'Renovacion',false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="Renovacion">Renovación</label>
					</div>
				</div>			
			</div>
			<div class="col-4 form-group d-none" id="certificado_vencido">
				{!! Form::label('nrocertificado_vencido', 'Nro. Certificado Vencido*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('nrocertificado_vencido', null, array('class' => 'form-control  input-xs', 'id' => 'nrocertificado_vencido')) !!}
				</div>
			</div>
			<div class="col-8 form-group" id="divFuncionario">
				{!! Form::label('funcionario', 'Funcionario al que dirige la solicitud*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<select class="form-control input-xs" name="funcionario" id="funcionario">
					<option value="Funcionario">Funcionario Municipal: Sr. Pablo Romero Zapata</option>
					<option value="Alcalde">Alcalde: Wilmer Guevara Diaz</option>
				</select>
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
				{!! Form::label('nombrenegocio', 'Nombre del Negocio*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('nombrenegocio', null, array('class' => 'form-control  input-xs', 'id' => 'nombrenegocio')) !!}
				</div>
			</div>
				
		</div>
		<div class="row">
			<div class="form-group col-8">
				{!! Form::label('girocomercial', 'Giro Comercial*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('girocomercial', null, array('class' => 'form-control  input-xs', 'id' => 'girocomercial')) !!}
				</div>
			</div>
			<div class="form-group col-4">
				{!! Form::label('telefono', 'Teléfono', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('telefono', null, array('class' => 'form-control  input-xs', 'id' => 'telefono')) !!}
				</div>
			</div>
		</div>
	</div>	
	<div class="form-group">
		{!! Form::label('direccion', 'Dirección', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('direccion', null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('observacion', 'Observación', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observacion', null, array('class' => 'form-control  input-xs', 'id' => 'observacion','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('900');
	var tipotogle = $('#toggletipo').val();
	showTipo(tipotogle);
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni"]').inputmask("99999999");

	$('#botonBuscarRuc').on('click', function(){
		buscarRUC();
	});

	$("input[name=solicito]").change(function () {	
		var valor = $(this).val(); 
		
		if(valor == 'Renovacion'){
			$('#certificado_vencido').removeClass('d-none');
			$('#divFuncionario').removeClass('col-8').addClass('col-4');
		}else {
			$('#certificado_vencido').addClass('d-none');
			$('#divFuncionario').removeClass('col-4').addClass('col-8');

		}
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
function showTipo(tipo){
		console.log(tipo);
		switch (tipo) {
			case "1":
				$('#divSalubridad').addClass('d-none');
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
        url: "{{route('solicitud.generarnumero')}}",
        data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo"]').val(),
        success: function(a) {
            $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
        }
    });
}
</script>