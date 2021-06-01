<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($solicitud, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('fecha', 'Fecha de Solicitud', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha', date('Y-m-d'), array('class' => 'form-control  input-xs', 'id' => 'fecha' , 'readonly' => true)) !!}
			</div>
		</div>
		<div class="col-sm form-groupe">
			{!! Form::label('numero', 'Nro. Correlativo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
	</div>
	<div class="row text-center justify-content-center">
			<div class="row  form-group ml-2">
				<div class="form-check form-check-inline">
					{{Form::radio('tiposolicitud', 'Definitiva', false , array("class"=>"form-check-input"))}}
					<label class="form-check-label" for="Definitiva">Definitiva</label>
				</div>
				<div class="form-check form-check-inline">
					{{Form::radio('tiposolicitud', 'Temporal',false , array("class"=>"form-check-input"))}}
					<label class="form-check-label" for="Temporal">Temporal</label>
				</div>
			</div>			
	</div>
	<div class="row container p-1">
		{!! Form::label('tipotramitesolicitud', 'Tipo de trámite que solicita', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="row">
			<div class="col-sm">
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento, establecimiento hasta 100M2 con ITSE BASICA EX POST"> Licencia de Funcionamiento, establecimiento hasta 100M2 con ITSE BASICA EX POST <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento, establecimiento mas de 100M2 hasta 500 M2 con ITSE BASICA EX ANTES"> Licencia de Funcionamiento, establecimiento mas de 100M2 hasta 500 M2 con ITSE BASICA EX ANTES<br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento, establecimiento mas de 500M2 que requieren de una ITSE de detalle o multidisciplinaria"> Licencia de Funcionamiento, establecimiento mas de 500M2 que requieren de una ITSE de detalle o multidisciplinaria <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento, mercados y abastos y galeria comerciales"> Licencia de Funcionamiento, mercados y abastos y galeria comerciales <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Modificación y/o Adecuación de la Licencia de Funcionamiento"> Modificación y/o Adecuación de la Licencia de Funcionamiento <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="En forma conjunta con anuncio publicitario simple y/o toldo"> En forma conjunta con anuncio publicitario simple y/o toldo <br/>
			</div>
			<div class="col-sm">
				<input type="checkbox" name="tipotramitesolicitud[]" value="En forma conjunta con anuncio publicitario Luminoso o Iluminado y/o toldo"> En forma conjunta con anuncio publicitario Luminoso o Iluminado y/o toldo <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento: Cesionarios hasta 100M2 con ITSE EX POST"> Licencia de Funcionamiento: Cesionarios hasta 100M2 con ITSE EX POST <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento: Cesionarios hasta 100M2 con ITSE EX ANTES"> Licencia de Funcionamiento: Cesionarios hasta 100M2 con ITSE EX ANTES <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Licencia de Funcionamiento: Cesionarios mas de 500M2 que que requieren de una ITSE de detalle multidisciplinaria"> Licencia de Funcionamiento: Cesionarios mas de 500M2 que que requieren de una ITSE de detalle multidisciplinaria <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Cese de Actividades"> Cese de Actividades <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Duplicado de Licencia de Funcionamiento Definitivo o Temporal"> Duplicado de Licencia de Funcionamiento Definitivo o Temporal <br/>
				<input type="checkbox" name="tipotramitesolicitud[]" value="Otros"> Otros <br/>
			</div>
		</div>
	</div>
	<legend>Datos del solicitante</legend>
	<div class="row">		
		<div class="col-4 form-group">
			{!! Form::label('nombresolicitante', 'Apellidos y Nombres*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nombresolicitante', null, array('class' => 'form-control  input-xs', 'id' => 'nombresolicitante')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			{!! Form::label('dni', 'DNI*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dni', null, array('class' => 'form-control  input-xs', 'id' => 'dni')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
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
		<div class="form-group col-4">
			{!! Form::label('razonsocial', 'Razon Social*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('razonsocial', null, array('class' => 'form-control  input-xs', 'id' => 'razonsocial')) !!}
			</div>
		</div>
	</div>
	<div class="row">			
		<div class="form-group col-4">
			{!! Form::label('direccion', 'Dirección', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('direccion', null, array('class' => 'form-control  input-xs', 'id' => 'direccion')) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('numerocasa', 'Nro.', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numerocasa', null, array('class' => 'form-control  input-xs', 'id' => 'numerocasa')) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('manzanacasa', 'Mz.', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('manzanacasa', null, array('class' => 'form-control  input-xs', 'id' => 'manzanacasa')) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('lotecasa', 'Lte.', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('lotecasa', null, array('class' => 'form-control  input-xs', 'id' => 'lotecasa')) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('urbanizacion', 'Urb.', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('urbanizacion', null, array('class' => 'form-control  input-xs', 'id' => 'urbanizacion')) !!}
			</div>
		</div>
	</div>
	<legend>Representante legal</legend>
	<div class="row">
		<div class="col-4 form-group">
			{!! Form::label('representantelegal', 'Apellidos y Nombres*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('representantelegal', null, array('class' => 'form-control  input-xs', 'id' => 'representantelegal')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('dnirepresentante', 'DNI', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dnirepresentante', null, array('class' => 'form-control  input-xs', 'id' => 'dnirepresentante')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('rucrepresentante', 'RUC', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
					{!! Form::text('rucrepresentante', null, array('class' => 'form-control  input-xs', 'id' => 'rucrepresentante')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			{!! Form::label('telefonorepresentante', 'Teléfono', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('telefonorepresentante', null, array('class' => 'form-control  input-xs', 'id' => 'telefonorepresentante')) !!}
			</div>
		</div>
	</div>
	<legend>Datos del Establecimiento</legend>
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('nombrenegocio', 'Nombre del Negocio*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nombrenegocio', null, array('class' => 'form-control  input-xs', 'id' => 'nombrenegocio')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('girocomercial', 'Giro Comercial*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('girocomercial', null, array('class' => 'form-control  input-xs', 'id' => 'girocomercial')) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('area', 'Área Total(m2)', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblarea')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('area', null, array('class' => 'form-control  input-xs', 'id' => 'area', 'step'=>'0.01')) !!}
			</div>
		</div>
	</div>
	<legend>Requisitos y/o documentos que se Anexan</legend>
	<div class="row">
		<div class="col-sm">
			<div class="form-group">
				{!! Form::label('requisitos1[]', '1º', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('requisitos[]', null, array('class' => 'form-control  input-xs', 'id' => 'requisitos1[]')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('requisitos2[]', '2º', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('requisitos[]', null, array('class' => 'form-control  input-xs', 'id' => 'requisitos2[]')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('requisitos3[]', '3º', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('requisitos[]', null, array('class' => 'form-control  input-xs', 'id' => 'requisitos3[]')) !!}
				</div>
			</div>
		</div>
		<div class="col-sm">
			<div class="form-group">
				{!! Form::label('requisitos4[]', '4º', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('requisitos[]', null, array('class' => 'form-control  input-xs', 'id' => 'requisitos4[]')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('requisitos5[]', '5º', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('requisitos[]', null, array('class' => 'form-control  input-xs', 'id' => 'requisitos5[]')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('requisitos6[]', '6º', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('requisitos[]', null, array('class' => 'form-control  input-xs', 'id' => 'requisitos6[]')) !!}
				</div>
			</div>
		</div>
	</div>
	<legend>Tramite adicionales sobre anuncio</legend>
	<div class="row">
		<div class="col-3 form-group">
			{!! Form::label('publicidadexterior', 'Solicito Publicidad Exterior de Aviso', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="form-check form-check-inline">
				{{Form::radio('publicidadexterior', 'SI', false , array("class"=>"form-check-input"))}}
				<label class="form-check-label" for="SI">SI</label>
			</div>
			<div class="form-check form-check-inline">
				{{Form::radio('publicidadexterior', 'NO',false , array("class"=>"form-check-input"))}}
				<label class="form-check-label" for="NO">NO</label>
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('colores', 'Colores', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('colores', null, array('class' => 'form-control  input-xs', 'id' => 'colores')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('tipoanuncio', 'Tipo de Anuncio', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('tipoanuncio', null, array('class' => 'form-control  input-xs', 'id' => 'tipoanuncio', 'placeholder'=>'Ej. Letrero, Toldo, Placa')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('medidas', 'Medidas*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('medidas', null, array('class' => 'form-control  input-xs', 'id' => 'medidas')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-6">
			{!! Form::label('leyendas', 'Leyendas', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('leyendas', null, array('class' => 'form-control  input-xs', 'id' => 'leyendas')) !!}
			</div>
		</div>
		<div class="form-group col-4">
			{!! Form::label('materiales', 'Materiales', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('materiales', null, array('class' => 'form-control  input-xs', 'id' => 'materiales', 'placeholder'=>'Ej. Madera, Fierro, etc.')) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('cantidadanuncios', 'Cantidad de Anuncios', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('cantidadanuncios', null, array('class' => 'form-control  input-xs', 'id' => 'cantidadanuncios')) !!}
			</div>
		</div>
	</div>
	<legend>DUPLICADO DE LICENCIA DE FUNCIONAMIENTO</legend>
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('nroexpediente', 'Nro. de Expediente', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nroexpediente', null, array('class' => 'form-control  input-xs', 'id' => 'nroexpediente')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('nrocertificado', 'Nro. de Cartón', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nrocertificado', null, array('class' => 'form-control  input-xs', 'id' => 'nrocertificado')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('nroresolucion', 'Nro. de Resolución', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nroresolucion', null, array('class' => 'form-control  input-xs', 'id' => 'nroresolucion')) !!}
			</div>
		</div>
	</div>
	{{-- <div class="d-none" id="divSalubridad">
		<div class="row">
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
			
			<div class="form-group col-4">
				{!! Form::label('telefono', 'Teléfono', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('telefono', null, array('class' => 'form-control  input-xs', 'id' => 'telefono')) !!}
				</div>
			</div>
		</div>
	</div>	
	 --}}
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('1200');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="rucrepresentante"]').inputmask("99999999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni"]').inputmask("99999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dnirepresentante"]').inputmask("99999999");

	$('#botonBuscarRuc').on('click', function(){
		buscarRUC();
	});
	generarNumero();
	

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

function generarNumero(){
    $.ajax({
        type: "POST",
        url: "{{route('solicitud.generarnumero')}}",
        data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
        success: function(a) {
            $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
        }
    });
}
</script>