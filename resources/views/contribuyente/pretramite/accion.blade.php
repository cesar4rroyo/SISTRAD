<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($modelo, $formData) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
    {!! Form::label('motivo_rechazo', 'Comentario', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::textarea('motivo_rechazo', '', array('class' => 'form-control form-control-sm  input-xs', 'id' => 'motivo_rechazo','rows'=>5 , 'style' =>'resize:none;')) !!}
    </div>
</div>

<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check "></i> '.$boton, array('class' => 'btn  btn-sm'.$boton_class, 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-undo "></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal((contadorModal - 1));')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		configurarAnchoModal('800');
	});

</script>