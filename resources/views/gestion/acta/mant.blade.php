<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($acta, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="row ">
		<div class="col-sm form-group">
			{!! Form::label('fecha', 'Fecha Inicio de Fiscalización*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::input('dateTime-local', 'fecha', $acta ?  date('Y-m-d\TH:i', strtotime($acta->fecha)) : null, array('class' => 'form-control  input-xs', 'id' => 'fecha')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('fechafin', 'Fecha Termino de Fiscalización*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::input('dateTime-local','fechafin',$acta ?  date('Y-m-d\TH:i', strtotime($acta->fechafin)) : null, array('class' => 'form-control  input-xs', 'id' => 'fechafin')) !!}
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
		<div class="col-3 form-group">
			{!! Form::label('subgerencia', 'Sub Gerencia*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('subgerencia', null, array('class' => 'form-control  input-xs', 'id' => 'subgerencia')) !!}
			</div>
		</div>
		<div class="col-4 form-group">
			{!! Form::label('fiscalizador', 'Fiscalizador*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('fiscalizador', null, array('class' => 'form-control  input-xs', 'id' => 'fiscalizador')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			{!! Form::label('dnifiscalizador', 'DNI Fiscalizador*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dnifiscalizador', null, array('class' => 'form-control  input-xs', 'id' => 'dnifiscalizador', 'onchange'=>'handlechangeDNI(this.value, 1);')) !!}
			</div>
		</div>
		<div class="form-group col-3">
			{!! Form::label('file', 'Archivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::file('file', null, array('class' => 'form-control-file  input-xs', 'id' => 'file' )) !!}
			</div>
		</div>
	</div>
	@if ($acta)
	@php
		$participantes = explode(';',$acta->participante);
		$condicionparticipantes = explode(';',$acta->condicionparticipante);
	@endphp
	<section id="step1-B">
        <div id="scroll" class="scrollable">
        <div class="wrap">
            <div class="breakpoint">
				@foreach ($participantes as $item)
					<div id="to-add-first" class="outerDiv first">
						<div id="primary" class="clone">
							<div class="row">
									<div class="col-sm form-group">
										{!! Form::label('participante', 'Participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
										<div class="col-lg-12 col-md-12 col-sm-12">
										{!! Form::text('participante[]', $item, array('class' => 'form-control  input-xs', 'id' => 'participante[]')) !!}
										</div>
									</div>
									<div class="col-sm form-group">
										{!! Form::label('condicionparticipante', 'Condición del participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
										<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
											<div class="col-lg-11 col-md-11 col-sm-11">
												{!! Form::text('condicionparticipante[]', $condicionparticipantes[$loop->iteration-1], array('class' => 'form-control  input-xs', 'id' => 'condicionparticipante[]', 'placeholder'=>'Ej. Testigo, apoyo.')) !!}
											</div>
										</div>
									</div>
									<div class="col-2 mt-4">
										<ul class="options mt-2">
											<li class="delete list-unstyled">
												<a href="#" onClick="deleteAddress(this);return false" title="Eliminar" class="tip btn btn-danger">
													<i class=" fas fa-trash-alt"></i>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
        	 </div>
        </div>
        <a href="#" class="btn btn-primary mb-2 ml-2" onClick="addAddress();return false;" id="add-address">
			<i class=" fas fa-plus-circle"></i>
		</a>
    </section>
	{{-- <div class="e1">
		@foreach ($participantes as $item)
		<div class="row" class="e2">
			<div class="col-sm form-group">
				{!! Form::label('participante', 'Participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('participante[]', $item, array('class' => 'form-control  input-xs', 'id' => 'participante[]')) !!}
				</div>
			</div>
			<div class="col-sm form-group">
				{!! Form::label('condicionparticipante', 'Condición del participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
					<div class="col-lg-11 col-md-11 col-sm-11">
						{!! Form::text('condicionparticipante[]', $condicionparticipantes[$loop->iteration-1], array('class' => 'form-control  input-xs', 'id' => 'condicionparticipante[]', 'placeholder'=>'Ej. Testigo, apoyo.')) !!}
					</div>
				</div>
			</div>
			<button class="btn btn-primary mt-4 addParticipante" style="height: 50%">
				<i class=" fas fa-plus"></i>
			</button>
			<button class="btn btn-danger mt-4 removeParticipante" style="height: 50%">
				<i class=" fas fa-trash"></i>
			</button>	
		</div>
		@endforeach
	</div> --}}
	@else
	<section id="step1-B">
        <div id="scroll" class="scrollable">
        <div class="wrap">
            <div class="breakpoint">
                <div id="to-add-first" class="outerDiv first">
                    <div id="primary" class="clone">
						<div class="row">
							<div class="col-sm form-group">
								{!! Form::label('participante', 'Participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
								<div class="col-lg-12 col-md-12 col-sm-12">
									{!! Form::text('participante[]', null, array('class' => 'form-control  input-xs', 'id' => 'participante[]')) !!}
								</div>
							</div>
							<div class="col-sm form-group">
								{!! Form::label('condicionparticipante', 'Condición del participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
								<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
									<div class="col-lg-11 col-md-11 col-sm-11">
										{!! Form::text('condicionparticipante[]', null, array('class' => 'form-control  input-xs', 'id' => 'condicionparticipante[]', 'placeholder'=>'Ej. Testigo, apoyo.')) !!}
									</div>
								</div>
							</div>
							<div class="col-2 mt-4">
								<ul class="options mt-2">
									<li class="delete list-unstyled">
										<a href="#" onClick="deleteAddress(this);return false" title="Eliminar" class="tip btn btn-danger">
											<i class=" fas fa-trash-alt"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
                  </div>
                </div>
              </div>
         </div>
         </div>
        <a href="#" class="btn btn-primary mb-2 ml-2" onClick="addAddress();return false;" id="add-address">
			<i class=" fas fa-plus-circle"></i>
		</a>
    </section>
	{{-- <div class='e1'>
		<div class="row" class="e2">
			<div class="col-sm form-group">
				{!! Form::label('participante', 'Participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('participante[]', null, array('class' => 'form-control  input-xs', 'id' => 'participante[]')) !!}
				</div>
			</div>
			<div class="col-sm form-group">
				{!! Form::label('condicionparticipante', 'Condición del participante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
					<div class="col-lg-11 col-md-11 col-sm-11">
						{!! Form::text('condicionparticipante[]', null, array('class' => 'form-control  input-xs', 'id' => 'condicionparticipante[]', 'placeholder'=>'Ej. Testigo, apoyo.')) !!}
					</div>
				</div>
			</div>
			<button class="btn btn-primary mt-4 addParticipante" style="height: 50%">
				<i class=" fas fa-plus"></i>
			</button>
			<button class="btn btn-danger mt-4 removeParticipante" style="height: 50%">
				<i class=" fas fa-trash"></i>
			</button>
		</div>
	</div> --}}
	@endif
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
				{!! Form::text('dnirepresentante', null, array('class' => 'form-control  input-xs', 'id' => 'dnirepresentante', 'onchange'=>'handlechangeDNI(this.value, 2);')) !!}
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
	@if ($acta)
		@php
			$idArray = explode(';', $acta->conclusiones);
		@endphp
		<div class="form-group">
			{!! Form::label('conclusiones', 'Conclusiones del Acta del Fiscalizador', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12">
				<input type="checkbox" name="conclusiones[]" value="Certificación de conformidad"  <?php if(in_array('Certificación de conformidad',$idArray)) echo "checked" ;?> >Certificación de conformidad <br/>
				<input type="checkbox" name="conclusiones[]" value="Recomendación de mejoras" <?php if(in_array('Recomendación de mejoras',$idArray)) echo "checked" ;?>>  Recomendación de mejoras <br/>
				<input type="checkbox" name="conclusiones[]" value="Advertencia de incumplimiento" <?php if(in_array('Certificación',$idArray)) echo "checked" ;?>> Advertencia de incumplimiento <br/>
				<input type="checkbox" name="conclusiones[]" value="Recomendación de inicio de procedimiento sancionador" <?php if(in_array('Recomendación de inicio de procedimiento sancionador',$idArray)) echo "checked" ;?> >  Recomendación de inicio de procedimiento sancionador <br/>
				<input type="checkbox" name="conclusiones[]" value="Adopción de medidas provisionales" <?php if(in_array('Adopción de medidas provisionales',$idArray)) echo "checked" ;?>> Adopción de medidas provisionales <br/>
				<input type="checkbox" name="conclusiones[]" value="Clausura Inmediata" <?php if(in_array('Clausura Inmediata',$idArray)) echo "checked" ;?>> Clausura Inmediata <br/>
				<input type="checkbox" name="conclusiones[]" value="Paralización Inmediata" <?php if(in_array('Paralización Inmediata',$idArray)) echo "checked" ;?>> Paralización Inmediata <br/>
				<input type="checkbox" name="conclusiones[]" value="Cualquier mandato de hacer" <?php if(in_array('Cualquier mandato de hacer',$idArray)) echo "checked" ;?>> Cualquier mandato de hacer <br/>
				<input type="checkbox" name="conclusiones[]" value="Otros" id="cbotros" <?php if(in_array('Otros',$idArray)) echo "checked" ;?>> Otros <br/>
				<input type="text" name="conclusiones[]" value="<?php if(in_array('Otros',$idArray)) echo $idArray[count($idArray)-1] ;?>" id="divOtros" class="form-control input-xs d-none">
			</div>
		</div>
	@else
	<div class="form-group">
		{!! Form::label('conclusiones', 'Conclusiones del Acta del Fiscalizador', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12">
			<input type="checkbox" name="conclusiones[]" value="Certificación de conformidad">Certificación de conformidad <br/>
			<input type="checkbox" name="conclusiones[]" value="Recomendación de mejoras">  Recomendación de mejoras <br/>
			<input type="checkbox" name="conclusiones[]" value="Advertencia de incumplimiento"> Advertencia de incumplimiento <br/>
			<input type="checkbox" name="conclusiones[]" value="Recomendación de inicio de procedimiento sancionador">  Recomendación de inicio de procedimiento sancionador <br/>
			<input type="checkbox" name="conclusiones[]" value="Adopción de medidas provisionales"> Adopción de medidas provisionales <br/>
			<input type="checkbox" name="conclusiones[]" value="Clausura Inmediata"> Clausura Inmediata <br/>
			<input type="checkbox" name="conclusiones[]" value="Paralización Inmediata"> Paralización Inmediata <br/>
			<input type="checkbox" name="conclusiones[]" value="Cualquier mandato de hacer"> Cualquier mandato de hacer <br/>
			<input type="checkbox" name="conclusiones[]" value="Otros" id="cbotros"> Otros <br/>
			<input type="text" name="conclusiones[]" id="divOtros" class="form-control input-xs d-none">
		</div>
	</div>
	@endif
	<div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'type' => 'submit')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {

	configurarAnchoModal('1200');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dnirepresentante"]').inputmask("99999999");
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dnifiscalizador"]').inputmask("99999999");
	@if (!$acta)
		generarNumero();
	@endif
	drawNavigation();
	toggleOtros();
	$('#botonBuscarRuc').on('click', function(){
		buscarRUC();
	});
	$('.addParticipante').on('click', function(e){
		e.preventDefault();
		var parentnode=this.parentNode;
		var OuterHtml=parentnode.outerHTML;
		var TopLevel=parentnode.parentNode;
		$(TopLevel).append(OuterHtml);
	});
	$('.removeParticipante').on('click', function(e){
		e.preventDefault();
		var parentnode=this.parentNode;
		var OuterHtml=parentnode.outerHTML;
		var TopLevel=parentnode.parentNode;
		$(TopLevel).remove(OuterHtml);
	});

	$('input[type=checkbox][id=cbotros]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#divOtros').removeClass('d-none');
		}else{
			$('#divOtros').addClass('d-none');
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
function toggleOtros(){
	if ($('#cbotros').is(":checked")){
		$('#divOtros').removeClass('d-none');
	}
}
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

	function handlechangeDNI(e, tipo){
		if(e.length===8){
			consultarDNI(e, tipo);
		}
	}

	function consultarDNI(e, tipo){
		// 
			$.ajax({
				type: "POST",
				url: "{{route('ordenpago.buscarDNI')}}",
				data: "dni="+e+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
				success: function(a) {
					if(tipo==1){
						datos=JSON.parse(a);
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="fiscalizador"]').val(datos.nombres+' '+datos.apepat+' '+datos.apemat);
					}else{
						datos=JSON.parse(a);
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="representante"]').val(datos.nombres+' '+datos.apepat+' '+datos.apemat);
					}
					
				}
			});
	}

	//lista dinanimca
	//CODIGO ORIGINAL: https://jsfiddle.net/XeELs/132/
	var newId = (function() {
		var id = 1;
		return function() {
			return id++;
		};
	}());

	function drawNavigation() {
		var numAddresses = $("#to-add-first .clone").length;
		if (numAddresses > 1) {
			$("#primary li.delete").show();
		}
		else {
			$("#primary li.delete").hide();
		}
	}
	function addAddress() {
		var clone = $('#primary').clone().attr('id', newId());
		clone.find('[type=text]').val('');
		clone.find('li.delete').show();
		$('#to-add-first').append(clone);
		drawNavigation();
	}

	function deleteAddress(e) {
		$(e).parents(".clone").remove();
		drawNavigation();
	}
</script>
