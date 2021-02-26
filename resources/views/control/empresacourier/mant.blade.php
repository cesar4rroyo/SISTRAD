<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($empresacourier, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

	<div class="row">
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('ruc', 'RUC *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label ')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('ruc', null, array('class' => 'form-control input-xs', 'id' => 'ruc')) !!}
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('razonsocial', 'Razón social *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('razonsocial', null, array('class' => 'form-control input-xs', 'id' => 'razonsocial')) !!}
				</div>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('direccion', 'Dirección', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('direccion', null, array('class' => 'form-control input-xs', 'id' => 'direccion')) !!}
				</div>
			</div>
			
		</div>
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('representante', 'Representante', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('representante', null, array('class' => 'form-control input-xs', 'id' => 'representante')) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('telefono', 'Telefono', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('telefono', null, array('class' => 'form-control input-xs', 'id' => 'telefono' , 'onkeypress'=>'return filterFloat(event,this)')) !!}
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('email', 'Correo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('email', null, array('class' => 'form-control input-xs', 'id' => 'email')) !!}
				</div>
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
	configurarAnchoModal('800');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
}); 
</script>