<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($resolucionsancion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="row ">
		<div class="col-sm form-group">
			{!! Form::label('fechaemision', 'Fecha Emisión*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechaemision', date('Y-m-d'), array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fechaemision')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('ordenanza', 'Ordenanza Muninicapl Nº*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('ordenanza', null, array('class' => 'form-control  input-xs', 'id' => 'ordenanza')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>		
		<div class="col-sm form-group">
			{!! Form::label('fojas', 'Fojas*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('fojas', null, array('class' => 'form-control  input-xs', 'id' => 'fojas')) !!}
			</div>
		</div>		
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('nroinstruccion', 'Informe Instrucción Nro.*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('nroinstruccion', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'nroinstruccion')) !!}
			</div>
		</div>	
		<div class="col-sm form-group">
			{!! Form::label('fechainstruccion', 'Fecha de Instrucción *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fechainstruccion', date('Y-m-d'), array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fechainstruccion')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('actafiscalizacion_id', 'Acta de fiscalización', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('actafiscalizacion_id',$actas, ($resolucionsancion)?$resolucionsancion->actafiscalizacion_id:null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'actafiscalizacion_id' , 'onchange' => '')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('notificacioncargo_id', 'Notificación de Cargo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('notificacioncargo_id',$notificacion, ($resolucionsancion)?$resolucionsancion->notificacioncargo_id:null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'notificacioncargo_id' , 'onchange' => '')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('medidacorrectiva', 'Medida Complementaria', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('medidacorrectiva', null, array('class' => 'form-control  input-xs', 'id' => 'medidacorrectiva')) !!}
			</div>
		</div>	
		<div class="col-sm form-group">
			{!! Form::label('periodo', 'Período(días)', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('periodo', null, array('class' => 'form-control  input-xs', 'id' => 'periodo')) !!}
			</div>
		</div>	
	</div>
	<div class="form-group">
		{!! Form::label('domicilioprocesal', 'Domicilio Procesal*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('domicilioprocesal', null, array('class' => 'form-control  input-xs', 'id' => 'domicilioprocesal')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('descargo', 'Descargo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('descargo', null, array('class' => 'form-control  input-xs', 'id' => 'descargo','rows'=>2 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('conclusion', 'Conclusión*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('conclusion', null, array('class' => 'form-control  input-xs', 'id' => 'conclusion','rows'=>3 , 'style' =>'resize:none;')) !!}
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
	@if (!$resolucionsancion)
		generarNumero();
	@endif


}); 	

	function generarNumero(){
		$.ajax({
			type: "POST",
			url: "{{route('resolucionsancion.generarnumero')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo_id"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
			}
		});
	}
</script>
