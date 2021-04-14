<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($inspeccion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('toggletipo', $toggletipo, array('id'=>'toggletipo')) !!}
	<div class="row ">
		<div class="col-6 form-group">
			{!! Form::label('fecha', 'Fecha', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha', date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fecha' , 'readonly' => true)) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-7 form-group">
			{!! Form::label('tipo_id', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo', $cboTipos, null, array('class' => 'form-control  input-xs', 'id' => 'tipo_id')) !!}
			</div>
		</div>
		<div class="col-5 form-group">
			{!! Form::label('ordenpago_id', 'Nro. Orden pago', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('ordenpago_id',$cboOrdenpago , null, array('class' => 'form-control  input-xs', 'id' => 'ordenpago_id')) !!}
			</div>
		</div>
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
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('descripcion', null, array('class' => 'form-control  input-xs', 'id' => 'descripcion','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('observacion', 'Observacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observacion', null, array('class' => 'form-control  input-xs', 'id' => 'observacion','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('conclusiones', 'Conclusiones*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('conclusiones', null, array('class' => 'form-control  input-xs', 'id' => 'conclusiones','rows'=>2 , 'style' =>'resize:none;')) !!}
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
	configurarAnchoModal('1000');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	var tipotogle = $('#toggletipo').val();
	showTipo(tipotogle);
	/* $('#toggletipo').on('change', function(){
		var tipo = $(this).val();
		showTipo(tipo);
	});
	 */


	$('#tipo_id').on('change', function(){
		var tipo = $(this).val();
		if(tipo==''){
			tipo='no';
		}
		switch (tipo) {
			case "LICENCIAS DE FUNCIONAMIENTO Y AUTORIZACIONES":
				$('#divSalubridad').addClass('d-none');
				break;
			case "EDIFICACIONES URBANAS (LICENCIA DE EDIFICACIÓN O CONSTRUCCIONES)":
				$('#divSalubridad').addClass('d-none');
				break;
			case "SALUBRIDAD":
				$('#divSalubridad').removeClass('d-none');
				break;
			case "DEFENSA CIVIL":
				$('#divSalubridad').addClass('d-none');
				break;
			default:
				$('#divSalubridad').addClass('d-none');
				break;
		}
		ordenpagoSelect2(tipo);
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
}); 
function showTipo(tipo){
		switch (tipo) {
		case "LICENCIAS DE FUNCIONAMIENTO Y AUTORIZACIONES":
				$('#divSalubridad').addClass('d-none');
				break;
			case "EDIFICACIONES URBANAS (LICENCIA DE EDIFICACIÓN O CONSTRUCCIONES)":
				$('#divSalubridad').addClass('d-none');
				break;
			case "SALUBRIDAD":
				$('#divSalubridad').removeClass('d-none');
				break;
			case "DEFENSA CIVIL":
				$('#divSalubridad').addClass('d-none');
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
</script>
