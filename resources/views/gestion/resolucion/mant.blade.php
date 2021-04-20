<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($resolucion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('toggletipo', $toggletipo, array('id'=>'toggletipo')) !!}
	<div class="row ">
		<div class="col-4 form-group">
			{!! Form::label('fechaexpedicion', 'Fecha de Expedición*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechaexpedicion', date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fechaexpedicion' , 'readonly' => true)) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('fechavencimiento', 'Fecha de Vencimiento*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechavencimiento', null, array('class' => 'form-control  input-xs', 'id' => 'fechavencimiento')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6 form-group">
			{!! Form::label('tipo_id', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo',$tipostramite, null, array('class' => 'form-control  input-xs', 'id' => 'tipo_id' , 'onchange' => 'generarNumero();')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('ordenpago_id', 'Nro. Orden pago', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('ordenpago_id',$cboOrdenpago , null, array('class' => 'form-control  input-xs', 'id' => 'ordenpago_id')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('inspeccion_id', 'Nro. Inspección', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('inspeccion_id',$cboInspeccion , null, array('class' => 'form-control  input-xs', 'id' => 'inspeccion_id')) !!}
			</div>
		</div>
	</div>
	<div class="row d-none" id="divSalubridad">
		<div class="col-4 form-group">
			{!! Form::label('localidad', 'Localidad (Ubr.- PJ)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('localidad', null, array('class' => 'form-control  input-xs', 'id' => 'localidad')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('zona', 'Zona*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('zona', null, array('class' => 'form-control  input-xs', 'id' => 'zona')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('categoria', 'Categoría*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('categoria', null, array('class' => 'form-control  input-xs', 'id' => 'categoria')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6 form-group">
			{!! Form::label('dni', 'DNI', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dni', null, array('class' => 'form-control  input-xs', 'id' => 'dni')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
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
	</div>
	<div class="form-group">
		{!! Form::label('contribuyente', 'Contribuyente*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('contribuyente', null, array('class' => 'form-control  input-xs', 'id' => 'contribuyente')) !!}
		</div>
	</div>	
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('razonsocial', 'Razon Social*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('razonsocial', null, array('class' => 'form-control  input-xs', 'id' => 'razonsocial')) !!}
			</div>
		</div>	
		<div class="form-group col-sm">
			{!! Form::label('girocomercial', 'Giro Comercial*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('girocomercial', null, array('class' => 'form-control  input-xs', 'id' => 'girocomercial')) !!}
			</div>
		</div>	
	</div>
	<div class="form-group">
		{!! Form::label('direccion', 'Dirección*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('direccion', null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('observacion', 'Observacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
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
<style>
	.select2-container--default .select2-selection--single {
		height: fit-content !important;
	}
</style>
<script type="text/javascript">
$(document).ready(function() {
	//ordenpagoSelect2();
	//inspeccionSelect2();
	configurarAnchoModal('900');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni"]').inputmask("99999999");
	var tipotogle = $('#toggletipo').val();
	showTipo(tipotogle);

	
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
			case "1":
				$('#divSalubridad').addClass('d-none');
				break;
			case "2":
				$('#divSalubridad').addClass('d-none');
				break;
			case "3":
				$('#divSalubridad').removeClass('d-none');
				break;
			case "4":
				$('#divSalubridad').addClass('d-none');
				break;
			default:
				break;
		}
		ordenpagoSelect2(tipo);
		inspeccionSelect2(tipo);
}
function inspeccionSelect2(tipo){
		$('#inspeccion_id').select2({
			ajax: {
				delay: 250,
				url: '{{route('resolucion.listarInspeccion')}}',
				data: function (params) {
					var query = {
						search: params.term,
						tipo: tipo,
					}
					return query;
				},
				placeholder: 'Nro. de Inspección',
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
			url: "{{route('resolucion.generarnumero')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
			}
		});
	}
</script>