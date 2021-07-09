<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($tramite, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('pretramite_id', $tipo == 'VIRTUAL' ? $tramite->id: '', array('id' => 'pretramite_id')) !!}

<div class="row">
	<div class="col-6">
		<div class="row">
			<div class="col-6">
				<label>Tipo de tramite *</label>	
				<div class="row form-group ml-2">
					<div class="form-check form-check-inline">
						{{Form::radio('tipotramite', 'tupa', true , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="tupa">Tupa</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('tipotramite', 'interno', false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="interno">Interno</label>
					</div>
					{{-- <div class="form-check form-check-inline">
						{{Form::radio('tipotramite', 'externo', false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="externo">Externo</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('tipotramite', 'courier', false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="courier">Courier</label>
					</div> --}}
				</div>
			</div>
			<div class="col-6">
				<label>Forma de recepción *</label>	
				<div class="row form-group ml-2">
					<div class="form-check form-check-inline">
						{{Form::radio('formarecepcion', 'manual',$tipo=='VIRTUAL'?false: true , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="manual">Manual</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('formarecepcion', 'digital',$tipo=='VIRTUAL'?true: false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="digital">Digital</label>
					</div>
				</div>
			</div>
		</div>
		
				
	  
			<div class="row">
				<div class="col form-group">
					{!! Form::label('tipodocumento', 'Tipo documento *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::select('tipodocumento', $tipodocumentos, "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tipodocumento')) !!}
					</div>
				</div>
				<div class="col form-group">
					{!! Form::label('numero', 'Número *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('numero', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'numero')) !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-9 form-group">
					{!! Form::label('asunto', 'Asunto *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('asunto', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'asunto')) !!}
					</div>
				</div>
				<div class="col-3 form-group">
					{!! Form::label('folios', 'Folios *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::number('folios',  null ,array('class' => 'form-control form-control-sm input-xs', 'id' => 'folios')) !!}
					</div>
				</div>
			</div>
				
				<div class=" form-group " id ="divremitente">
					{!! Form::label('remitente', 'Remitente *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('remitente', null,array('class' => 'form-control form-control-sm input-xs typeahead ', 'id' => 'remitente', 'data-provide' => 'typeahead' , 'autocomplete' =>'off')) !!}
					</div>
				</div>
				<div class=" form-group " >
					{!! Form::label('correo', 'Correo', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('correo', null,array('class' => 'form-control form-control-sm input-xs ', 'id' => 'correo')) !!}
					</div>
				</div>
				<div class=" form-group" id="divprocedimiento">
					{!! Form::label('procedimiento', 'Procedimiento *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::select('procedimiento', [""=>"Indique el procedimiento"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'procedimiento')) !!}
					</div>
				</div>
				<div class="form-group d-none" id="divareadestino">
					{!! Form::label('areadestino', 'Area destino *', array('class' => 'control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::select('areadestino', [""=>"Indique el area destino"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'areadestino')) !!}
					</div>
				</div>
				
	</div>
	<div class="col-6">
		<div class=" form-group">
			{!! Form::label('tramiteref', 'Tramite ref.', array('class' => 'control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tramiteref', [""=>"Seleccione"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref')) !!}
			</div>
		</div>
		<div class=" form-group">
			{!! Form::label('archivador', 'Archivador', array('class' => 'control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('archivador', [""=>"Seleccione"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'archivador')) !!}
			</div>
		</div>
	<label>Prioridad </label>	
	<div class="row  form-group ml-2">
		<div class="form-check form-check-inline">
			{{Form::radio('prioridad', 'alta', false , array("class"=>"form-check-input"))}}
			<label class="form-check-label" for="alta">Alta</label>
		</div>
		<div class="form-check form-check-inline">
			{{Form::radio('prioridad', 'normal',true , array("class"=>"form-check-input"))}}
			<label class="form-check-label" for="normal">Normal</label>
		</div>
		<div class="form-check form-check-inline">
			{{Form::radio('prioridad', 'baja', false , array("class"=>"form-check-input"))}}
			<label class="form-check-label" for="baja">Baja</label>
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('observacion', 'Observación ', array('class' => 'control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::textarea('observacion', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'observacion', "rows"=>5 , "style"=>"resize:none;")) !!}
		</div>
	</div>
	</div>
</div>	
				
			{{-- FIN DATOS DEL EXPEDIENTE --}}
	
	
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
	<style>
		.typeahead { z-index: 1051; }
		.modal-body{overflow-y: inherit;}
	</style>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('1000');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

	// $('.typeahead').typeahead({
	// 	source: [
	// 		{id: "someId1", name: "Display name 1"},
	// 		{id: "someId2", name: "Display name 2"}
	// 	],
	// 	autoSelect: false
    // });
	generarNumero();
	tramitesSelect2();
	procedimientoSelect2();
	archivadoresSelect2();
	areadestinoSelect2();

	$.get('{{route('tramite.listarpersonal')}}', function(data){
		$("#remitente").typeahead({ source:data });
	},'json');


	$("input[name=tipotramite]").change(function () {	
		var valor = $(this).val(); 
		if(valor == 'tupa' || valor == 'interno' || valor == 'externo'){
			$('#divremitente').removeClass('d-none');
			$('#divdestino').addClass('d-none');
			
		}else if (valor == 'courier'){
			$('#divremitente').addClass('d-none');
			$('#divdestino').removeClass('d-none');
			destinoSelect2();
		}

		if(valor == 'tupa'){
			$('#divprocedimiento').removeClass('d-none');
			$('#divareadestino').addClass('d-none');
		}else {
			$('#divprocedimiento').addClass('d-none');
			$('#divareadestino').removeClass('d-none');
			areadestinoSelect2();
		}
	});


}); 

	function destinoSelect2(){
		$('#destino').select2({
			ajax: {
				delay: 250,
				url: '{{route('tramite.listarempresascourier')}}',
				placeholder: 'Indique el destino',
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

	function areadestinoSelect2(){
		$('#areadestino').select2({
			ajax: {
				delay: 250,
				url: '{{route('tramite.listarareas')}}',
				placeholder: 'Indique el area destino',
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

	function procedimientoSelect2(){
		$('#procedimiento').select2({
			ajax: {
				delay: 250,
				url: '{{route('tramite.listarprocedimientos')}}',
				placeholder: 'Indique el procedimiento',
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

	function archivadoresSelect2(){
		$('#archivador').select2({
			ajax: {
				delay: 250,
				url: '{{route('tramite.listararchivadores')}}',
				placeholder: 'Indique el archivador',
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

	function generarNumero(){
    $.ajax({
        type: "POST",
        url: "{{route('tramite.generarnumero')}}",
        data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
        success: function(a) {
            $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
        }
    });
}
</script>