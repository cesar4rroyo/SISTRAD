<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($ordenpago, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="row">
		@if ($ordenpago)
		<div class="{{$ordenpago->estado=='pendiente'?'col-12':'col-6'}}" id = 'divpendiente'>
		@else
		<div class="col-12" id = 'divpendiente'>
		@endif
			<div class="row ">
				<div class="col-6 form-group">
					{!! Form::label('fecha', 'Fecha', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::date('fecha', date('Y-m-d'), array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fecha' , 'readonly' => true)) !!}
					</div>
				</div>
				<div class="col-6 form-group">
					{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('numero', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'numero')) !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 form-group">
					{!! Form::label('tipo', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::select('tipotramite',$tipostramite, $ordenpago?$ordenpago->tipo_id:null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'tipotramite' , 'onchange' =>'generarNumero(); cambiarsubtipos();')) !!}
					</div>
				</div>
			</div>
			<div class="row">
				@if($ordenpago)
				<div class="col-9 form-group">
					{!! Form::label('subtipo', 'Subtipo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::select('subtipotramite',  $subtipos, $ordenpago->subtipo_id?$ordenpago->subtipo_id:'', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite' )) !!}
					</div>
				</div>
				@else
				<div class="col-9 form-group">
					{!! Form::label('subtipo', 'Subtipo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::select('subtipotramite',  ['' => '--Elije un subtipo'], null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite' )) !!}
					</div>
				</div>
				@endif
				@if ($ordenpago)
				<div class="col-3 form-group">
					{!! Form::label('monto', 'Monto*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('monto', $ordenpago->monto, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'monto')) !!}
					</div>
				</div>	
				@else
				<div class="col-3 form-group">
					{!! Form::label('monto', 'Monto*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('monto', '0.00', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'monto')) !!}
					</div>
				</div>	
				@endif
				
			</div>
			<div class="row">
				{{-- <div class="col-4 form-group">
					{!! Form::label('dni_ruc', 'DNI/RUC*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('dni_ruc', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'dni_ruc' , 'maxlength' => '11' ,'onkeypress'=>'return filterFloat(event,this)' )) !!}
						<span class="input-group-btn">
							{!! Form::button('<i class="fa fa-check" id="ibtnConsultar"></i>', array('style'=>'background:#00a8cc; color:white;','class'
							=> 'btn  waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnConsultar', 'onclick'
							=> 'consultaRUC()')) !!}
						</span>
					</div>

				</div> --}}
				<div class=" col-6 form-group">
					{!! Form::label('dni_ruc', 'DNI/RUC*', array('class' => 'col-sm-3 col-xs-12 control-label input-sm','id'=>'lbldniruc', 'style'=>'')) !!}
					<div class="input-group" style="padding-left:10px;">
						{!! Form::text('dni_ruc', null, array('class' => 'form-control form-control-sm input-sm ', 'id' => 'dni_ruc','maxlength' => '11' , 'onkeypress'=>'return filterFloat(event,this)')) !!}
						<span class="input-group-btn">
							{!! Form::button('<i class="fa fa-search" id="ibtnConsultar"></i>', array('style'=>'background:#00a8cc; color:white; height:30px;','class'=> 'btn  waves-effect waves-light  btn-sm', 'id' => 'btnConsultar')) !!}
						</span>
					</div>
				</div>
				<div class="col-6 form-group">
					{!! Form::label('contribuyente', 'Contribuyente*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('contribuyente', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'contribuyente')) !!}
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('direccion', 'Dirección', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('direccion', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'direccion')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('representante', 'Representante legal', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('representante', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'representante')) !!}
				</div>
			</div>
			
			
			<div class="form-group">
				{!! Form::label('descripcion', 'Descripción', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::textarea('descripcion', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'descripcion','rows'=>2 , 'style' =>'resize:none;')) !!}
				</div>
			</div>
		
			<div class="row">
				<label class="ml-3">Estado</label>	
				<div class="row form-group ml-2">
					@if ($ordenpago)
						<div class="form-check form-check-inline">
							{{Form::radio('estado', 'pendiente', $ordenpago->estado=='pendiente'?true:false , array("class"=>"form-check-input" , 'onclick' => 'verificarEstado(this.value);'))}}
							<label class="form-check-label" for="pendiente">Pendiente</label>
						</div>
						<div class="form-check form-check-inline">
							{{Form::radio('estado', 'confirmado',  $ordenpago->estado=='confirmado'?true:false  , array("class"=>"form-check-input" , 'onclick' => 'verificarEstado(this.value);'))}}
							<label class="form-check-label" for="confirmado">Confirmado</label>
						</div>
					@else
					<div class="form-check form-check-inline">
						{{Form::radio('estado', 'pendiente', true , array("class"=>"form-check-input" , 'onclick' => 'verificarEstado(this.value);'))}}
						<label class="form-check-label" for="pendiente">Pendiente</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('estado', 'confirmado',  false  , array("class"=>"form-check-input" , 'onclick' => 'verificarEstado(this.value);'))}}
						<label class="form-check-label" for="confirmado">Confirmado</label>
					</div>
					@endif
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
		</div>
		@if ($ordenpago)
		<div class="{{$ordenpago->estado=='pendiente'?'col-6 d-none':'col-6'}}" id = 'divconfirmado'>
		@else
			<div class="col-6 d-none" id='divconfirmado'>
		@endif
			@if ($ordenpago)
			<div class=" form-group">
				{!! Form::label('tramiteref', 'Tramite ref.', array('class' => 'control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('tramiteref', $tramites, $ordenpago->tramiteref_id,array('class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref')) !!}
				</div>
			</div>	
			@else
			<div class=" form-group">
				{!! Form::label('tramiteref', 'Tramite ref.', array('class' => 'control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('tramiteref', [""=>"Seleccione"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref')) !!}
				</div>
			</div>	
			@endif
			<div class="row">
				<div class="col-6 form-group">
					{!! Form::label('numerooperacion', 'Numero operación*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::text('numerooperacion', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'numerooperacion' , 'minlength' => '3' )) !!}
					</div>
				</div>
				<div class="col-6 form-group">
					{!! Form::label('fechaoperacion', 'Fecha operacion*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
					<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::date('fechaoperacion',date('Y-m-d') , array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fechaoperacion')) !!}
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('cuenta', 'Cuenta', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('cuenta', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'cuenta')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('file', 'Archivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::file('file', null, array('class' => 'form-control-file  input-xs', 'id' => 'file' )) !!}
				</div>
		</div>
		
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
	@if ($ordenpago)
		@if ($ordenpago->estado == 'pendiente')
		configurarAnchoModal('800');	
		@else
		configurarAnchoModal('1000');
		tramitesSelect2();
		@endif
	@else
		configurarAnchoModal('800');	
	@endif
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

	$('#monto').inputmask('decimal', { rightAlign: false , digits:2  });

	// $("input#dni_ruc").bind('keypress', function(event) {
	// 	var regex = new RegExp("^[0-9]+$");
	// 	var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	// 		if (!regex.test(key)) {
	// 			event.preventDefault();
	// 			return false;
	// 		}
	// });
	
	

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
function cambiarsubtipos(){
	  var tipotramite_id =	$('#tipotramite').val();
	  if(tipotramite_id.length > 0){
		  $.ajax({
                url: "{{ route('ordenpago.listarsubtipos') }}",
                type: 'GET',
                data: { tipotramite_id },
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

	function verificarEstado(value){
		console.log(value);
		if(value == 'pendiente'){
			$('#divconfirmado').addClass('d-none');
			configurarAnchoModal('700');
			$('#divpendiente').removeClass('col-6').addClass('col-12');
		}else if(value == 'confirmado'){
			configurarAnchoModal('1000');
			$('#divpendiente').removeClass('col-12').addClass('col-6');
			$('#divconfirmado').removeClass('d-none');
			tramitesSelect2();
		}	
	}

function generarNumero(){
    $.ajax({
        type: "POST",
        url: "{{route('ordenpago.generarnumero')}}",
        data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipotramite=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipotramite"]').val(),
        success: function(a) {
            $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
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

	$('#btnConsultar').on('click', function(){
			let valor = $('#dni_ruc').val();
					if(valor.length == 8){
						consultarDNI();
					}else if (valor.length == 11){
						consultaRUC();
					}else{
						alert('Ingrese un documento válido');
					}
		});


		
	function consultarDNI(){
		// 
			$.ajax({
				type: "POST",
				url: "{{route('ordenpago.buscarDNI')}}",
				data: "dni="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni_ruc"]').val()+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
				success: function(a) {
					datos=JSON.parse(a);
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="contribuyente"]').val(datos.nombres+' '+datos.apepat+' '+datos.apemat);
				}
			});
}

function consultaRUC(){
        $.ajax({
            type: "POST",
            url: "{{route('ordenpago.buscarRUC')}}",
            data: "ruc="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni_ruc"]').val()+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
            success: function(a) {
                datos=JSON.parse(a);
				if(datos.length == 0){
					toastr.error('El DNI o RUC ingresado es incorrecto', 'Error');
				}else{
					$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="contribuyente"]').val(datos.RazonSocial);
					$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="direccion"]').val(datos.Direccion);
				}
            }
        });
   
}
</script>

