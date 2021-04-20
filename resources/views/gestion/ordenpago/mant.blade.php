<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($ordenpago, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
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
		<div class="col-9 form-group">
			{!! Form::label('tipo', 'Tipo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tipo',$tipostramite, null, array('class' => 'form-control  input-xs', 'id' => 'tipo' , 'onchange' => 'generarNumero();')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('monto', 'Monto*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('monto', '0.00', array('class' => 'form-control  input-xs', 'id' => 'monto')) !!}
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="col-4 form-group">
			{!! Form::label('dni_ruc', 'DNI/RUC*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('dni_ruc', null, array('class' => 'form-control  input-xs', 'id' => 'dni_ruc' , 'maxlength' => '11' )) !!}
			</div>
		</div>
		<div class="col-8 form-group">
			{!! Form::label('contribuyente', 'Contribuyente*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('contribuyente', null, array('class' => 'form-control  input-xs', 'id' => 'contribuyente')) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('dirección', 'Dirección', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('dirección', null, array('class' => 'form-control  input-xs', 'id' => 'dirección')) !!}
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('descripcion', null, array('class' => 'form-control  input-xs', 'id' => 'descripcion','rows'=>2 , 'style' =>'resize:none;')) !!}
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
	configurarAnchoModal('700');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

	$('#monto').inputmask('decimal', { rightAlign: false , digits:2  });

	$("input#dni_ruc").bind('keypress', function(event) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});
}); 


function generarNumero(){
    $.ajax({
        type: "POST",
        url: "{{route('ordenpago.generarnumero')}}",
        data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo"]').val(),
        success: function(a) {
            $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
        }
    });
}
</script>