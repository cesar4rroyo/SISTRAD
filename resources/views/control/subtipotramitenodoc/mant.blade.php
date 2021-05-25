<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($subtipotramitenodoc, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

	<div class="form-group">
		{!! Form::label('tipotramite', 'Tipo trámite:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('tipotramite', $tipostramite , $subtipotramitenodoc?$subtipotramitenodoc->tipotramitenodoc_id:'', array('class' => 'form-control input-xs', 'id' => 'tipotramite')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('nombre', 'Descripción:', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion', 'placeholder' => 'Ingrese la descripción')) !!}
		</div>
	</div>
	<div class="row">
		<div class=" col-8 form-group">
			{!! Form::label('codigo', 'Código:', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('codigo', null, array('class' => 'form-control input-xs', 'id' => 'codigo')) !!}
			</div>
		</div>
		<div class=" col-4 form-group">
			{!! Form::label('monto', 'Monto', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('monto', $subtipotramitenodoc?$subtipotramitenodoc->monto:'0.00', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'monto')) !!}
			</div>
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
	configurarAnchoModal('600');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

	$('#monto').inputmask('decimal', { rightAlign: false , digits:2  });
}); 
</script>