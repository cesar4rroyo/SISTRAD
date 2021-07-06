<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($infraccion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('codigo', 'Código:', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('codigo', null, array('class' => 'form-control input-xs', 'id' => 'codigo', 'placeholder' => 'Ingrese el código')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('procedimiento', 'Procedimiento:', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('procedimiento', null, array('class' => 'form-control input-xs', 'id' => 'procedimiento', 'placeholder' => 'Ingrese el Procedimiento')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('tipo', 'Tipo:', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('tipo', null, array('class' => 'form-control input-xs', 'id' => 'tipo', 'placeholder' => 'Ingrese el tipo')) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción ', array('class' => 'control-label ml-1')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::textarea('descripcion', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'descripcion', "rows"=>3 , "style"=>"resize:none;")) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('medidacomplementaria', 'Medida Complementaria ', array('class' => 'control-label ml-1')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::textarea('medidacomplementaria', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'medidacomplementaria', "rows"=>3 , "style"=>"resize:none;")) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('uit', 'Porcentaje UIT', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('uit', null, array('class' => 'form-control input-xs', 'id' => 'uit', 'placeholder' => 'Ingrese el porcentaje de la UIT', 'step'=>'.01')) !!}
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
	configurarAnchoModal('800');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
}); 
</script>