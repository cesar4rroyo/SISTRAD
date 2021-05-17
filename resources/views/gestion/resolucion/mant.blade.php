<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($resolucion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('toggletipo', $toggletipo, array('id'=>'toggletipo')) !!}
	<div class="row ">
		<div class="col-4 form-group">
			{!! Form::label('fechaexpedicion', 'Fecha de Expedición*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechaexpedicion', ($resolucion) ? date_create($resolucion->fechaexpedicion) : date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fechaexpedicion' , 'readonly' => true)) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('fechavencimiento', 'Fecha de Vencimiento*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechavencimiento', ($resolucion) ? date_create($resolucion->fechavencimiento) : null, array('class' => 'form-control  input-xs', 'id' => 'fechavencimiento')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('tipo_id', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo',$tipostramite, $toggletipo, array('class' => 'form-control  input-xs', 'id' => 'tipo_id' , 'onchange' => 'generarNumero(); cambiarsubtipos();')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		@if($resolucion)
			<div class="col-8 form-group">
				{!! Form::label('subtipo', 'Subtipo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('subtipotramite',  $subtipos, $resolucion->subtipo_id?$resolucion->subtipo_id:'', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite', 'onchange'=>'handleChangeSubtipo();' )) !!}
				</div>
			</div>
			@else
			<div class="col-8 form-group">
				{!! Form::label('subtipo', 'Subtipo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('subtipotramite',  ['' => '--Elije un subtipo'], null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite' , 'onchange'=>'handleChangeSubtipo();' )) !!}
				</div>
			</div>
			@endif
			@if ($resolucion)
			<div class=" form-group col-4">
				{!! Form::label('tramiteref', 'Tramite ref.', array('class' => 'control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('tramiteref', $tramites, $resolucion->tramiteref_id,array('class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref')) !!}
				</div>
			</div>	
			@else
			<div class=" form-group col-4">
				{!! Form::label('tramiteref', 'Tramite ref.', array('class' => 'control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('tramiteref', [""=>"Seleccione"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref')) !!}
				</div>
			</div>	
			@endif
	</div>
	<div class="row">
		<div class="col-4 form-group">
			{!! Form::label('numero', 'Número de Resolución*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblnrodocumento')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('ordenpago_id', 'Nro. Orden pago', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('ordenpago_id',$cboOrdenpago , null, array('class' => 'form-control  input-xs', 'id' => 'ordenpago_id')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
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
	<div id="divEdificaciones" class="d-none">
		<div class="form-group">
			{!! Form::label('proyecto', 'Proyecto*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblproyecto')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('proyecto', null, array('class' => 'form-control  input-xs', 'id' => 'proyecto', 'placeholder'=>'Ejm. LICENCIA DE CONSTRUCCION DE OBRA NUEVA VIVIENDA UNIFAMILIAR')) !!}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm">
				{!! Form::label('uso', 'Uso*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lbluso')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('uso', null, array('class' => 'form-control  input-xs', 'id' => 'uso', 'placeholder'=>'Ejm. Vivienda')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('zonificacion', 'Zonificación*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblzonificacion')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('zonificacion', null, array('class' => 'form-control  input-xs', 'id' => 'zonificacion', 'placeholder'=>'Ejm. R.D.M')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('altura', 'Altura*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblaltura')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('altura', null, array('class' => 'form-control  input-xs', 'id' => 'altura', 'placeholder'=>'Ejm. 01 Nivel')) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm">
				{!! Form::label('area', 'Área Construida(m2)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblarea')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('area', null, array('class' => 'form-control  input-xs', 'id' => 'area', 'step'=>'0.01')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('valor', 'Valor de la Obra(S/.)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblvalor')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('valor', null, array('class' => 'form-control  input-xs', 'id' => 'valor', 'step'=>'0.01')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('responsableobra', 'Responsable de la Obra*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblresponsableobra')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('responsableobra', null, array('class' => 'form-control  input-xs', 'id' => 'responsableobra')) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="d-none" id="divLicenciasAutorizaciones">
		<div class="d-none" id="divAnuncios">
			<div class="row">
				<div class="form-group col-sm">
					{!! Form::label('claseanuncio', 'Clase*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblclaseanuncio')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('claseanuncio', null, array('class' => 'form-control  input-xs', 'id' => 'claseanuncio', 'placeholder'=>'Ej. LUMINOSO')) !!}
					</div>
				</div>
				<div class="form-group col-sm">
					{!! Form::label('ubicacionanuncio', 'Ubicación*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblubicacionanuncio')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('ubicacionanuncio', null, array('class' => 'form-control  input-xs', 'id' => 'ubicacionanuncio', 'placeholder'=>'Ej. EN FACHADA')) !!}
					</div>
				</div>
				<div class="form-group col-sm">
					{!! Form::label('vigencia', 'Vigencia (Años)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblvigencia')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('vigencia', null, array('class' => 'form-control  input-xs', 'id' => 'vigencia', 'placeholder'=>'Ej. 02')) !!}
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('leyenda', 'Leyenda del Anuncio*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblleyenda')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('leyenda', null, array('class' => 'form-control  input-xs', 'id' => 'leyenda', 'placeholder'=>'')) !!}
					</div>
			</div>
		</div>
		<div class="row" id="divLicenciasFuncionamiento">
			<div class="form-group col-sm">
				{!! Form::label('nombrecomercial', 'Nombre Comercial*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblnombrecomercial')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('nombrecomercial', null, array('class' => 'form-control  input-xs', 'id' => 'nombrecomercial')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('funcionamiento', 'Tipo de Funcionamiento*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="row  form-group ml-2">
					<div class="form-check form-check-inline">
						{{Form::radio('funcionamiento', 'Temporal', true , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="Temporal">Temporal</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('funcionamiento', 'Definitivo',false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="Definitivo">Definitivo</label>
					</div>
				</div>
			</div>
			<div class="col-sm form-group">
				{!! Form::label('viapublica', 'Uso de Vía Pública*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="row  form-group ml-2">
					<div class="form-check form-check-inline">
						{{Form::radio('viapublica', 'Si', false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="Si">Sí</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('viapublica', 'No',true , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="No">No</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm form-group" id="certificadoGroup">
				{!! Form::label('nrocertificado', 'Certificado Nro*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblnrocertificado')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('nrocertificado', null, array('class' => 'form-control  input-xs', 'id' => 'nrocertificado')) !!}
				</div>
			</div>
			<div class="form-group col-sm d-none" id="divNombreComercial">
				{!! Form::label('nombrecomercial2', 'Nombre Comercial*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblnombrecomercial2')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('nombrecomercial2', $resolucion ? $resolucion->nombrecomercial : null, array('class' => 'form-control  input-xs', 'id' => 'nombrecomercial2')) !!}
				</div>
			</div>
			<div class="form-group col-sm">
				{!! Form::label('arearesolucion', 'Área (m2)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblarea')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('arearesolucion', $resolucion ? $resolucion->area : null, array('class' => 'form-control  input-xs', 'id' => 'arearesolucion', 'step'=>'0.01')) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-sm form-group">
			{!! Form::label('dni', 'DNI', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dni', null, array('class' => 'form-control  input-xs', 'id' => 'dni')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
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
		{!! Form::label('contribuyente', 'Contribuyente*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblcontribuyente')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('contribuyente', null, array('class' => 'form-control  input-xs', 'id' => 'contribuyente')) !!}
		</div>
	</div>	
	<div class="row" id="inforuc">
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
		{!! Form::label('direccion', 'Dirección*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lbldireccion')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('direccion', null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('observacion', 'Observacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observacion', $resolucion->observaciones ?? null, array('class' => 'form-control  input-xs', 'id' => 'observacion','rows'=>2 , 'style' =>'resize:none;')) !!}
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
	configurarAnchoModal('1000');
	tramitesSelect2();
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
function handleChangeSubtipo(){
	var subtipo = $('#subtipotramite').val();
	var tipo = $('#tipo_id').val();
	if(tipo=='1'){
		if(subtipo=='1'){
			$('#certificadoGroup').removeClass('d-none');
			$('#lblnrodocumento').text('Nro. de Resolución');
			$('#divAnuncios').addClass('d-none');
			$('#divLicenciasFuncionamiento').removeClass('d-none');
			$('#divNombreComercial').addClass('d-none');
			generarNumero2(subtipo, tipo);
			generarNumero3(subtipo, tipo);
		}else if(subtipo=='2' || subtipo=='3'){
			if(subtipo=='2'){
				$('#divAnuncios').removeClass('d-none');
				$('#divLicenciasFuncionamiento').addClass('d-none');
				$('#divNombreComercial').addClass('d-none');
			}
			if(subtipo=='3'){
				$('#divAnuncios').addClass('d-none');
				$('#divLicenciasFuncionamiento').addClass('d-none');
				$('#divNombreComercial').removeClass('d-none');
			}
			generarNumero3(subtipo, tipo);
			$('#certificadoGroup').addClass('d-none');
			$('#lblnrodocumento').text('Nro. de Autorización');
		}
	}
}
function showTipo(tipo){
		switch (tipo) {
			case "1":
				$('#divSalubridad').addClass('d-none');
				$('#divEdificaciones').addClass('d-none');
				$('#inforuc').removeClass('d-none');
				$('#divLicenciasAutorizaciones').removeClass('d-none');
				$('#lblcontribuyente').text('Contribuyente*');
				$('#lbldireccion').text('Dirección*');
				$('#lblnrodocumento').text('Nro. de Resolucion');


				break;
			case "2":
				$('#divSalubridad').addClass('d-none');
				$('#divEdificaciones').removeClass('d-none');
				$('#lblcontribuyente').text('Propietario*');
				$('#lbldireccion').text('Ubicación*');
				$('#inforuc').addClass('d-none');
				$('#divLicenciasAutorizaciones').addClass('d-none');
				$('#lblnrodocumento').text('Nro. de Resolución');


				break;
			case "3":
				$('#divSalubridad').removeClass('d-none');
				$('#divEdificaciones').addClass('d-none');
				$('#inforuc').removeClass('d-none');
				$('#lblcontribuyente').text('Contribuyente*');
				$('#lbldireccion').text('Dirección*');
				$('#divLicenciasAutorizaciones').addClass('d-none');
				$('#lblnrodocumento').text('Nro. de Certificado');


				break;
			case "4":
				$('#divSalubridad').addClass('d-none');
				$('#divEdificaciones').addClass('d-none');
				$('#inforuc').removeClass('d-none');
				$('#lblcontribuyente').text('Contribuyente*');
				$('#lbldireccion').text('Dirección*');
				$('#divLicenciasAutorizaciones').addClass('d-none');
				$('#lblnrodocumento').text('Nro. de Resolución');

				break;
			default:
				$('#lblcontribuyente').text('Contribuyente*');
				$('#lbldireccion').text('Dirección*');
				$('#divLicenciasAutorizaciones').addClass('d-none');
				$('#lblnrodocumento').text('Nro. de Resolución');

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


function generarNumero2(value, tipo){
		var subtipo = value;
		showTipo(tipo);
		$.ajax({
			type: "POST",
			url: "{{route('resolucion.generarnumero2')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&subtipotramite=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="subtipotramite"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="nrocertificado"]').val(a);
			}
		});
	}
function generarNumero3(value, tipo){
		var subtipo = value;
		showTipo(tipo);
		$.ajax({
			type: "POST",
			url: "{{route('resolucion.generarnumero2')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&subtipotramite=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="subtipotramite"]').val(),
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

	function tramitesSelect2(){
		$('#tramiteref').select2({
			ajax: {
				delay: 250,
				url: '{{route('tramite.listartramites')}}',
				placeholder: 'Indique el trámite de referencia',
				minimumInputLength: 1,
				processResults: function (data) {
					var datos = JSON.parse(data);
					return {
						results: datos.results
					};
				}
			}
		});
	}

</script>

