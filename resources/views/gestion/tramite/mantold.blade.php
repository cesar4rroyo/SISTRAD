<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($tramite, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

	
	<div class="row">
		<div class="col-6">
		{{--DATOS DEL SOLICITANTE  --}}
			<div class="card card-primary" >
				<div class="card-header">
					<h5 class="card-title">DATOS DEL SOLICITANTE</h5>
				</div>
				<div class="card-body">
				<div class="row">
					<div class="col form-group">
						{!! Form::label('tipopersona', 'Tipo persona', array('class' => 'control-label')) !!}
						<div class="col-lg-12 col-md-12 col-sm-12">
							{!! Form::select('tipopersona', ["N" => "Natural" , "J" => "Juridica"], "N",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tipopersona')) !!}
						</div>
					</div>
					<div class="col form-group">
						{!! Form::label('tipodocpersona', 'Tipo documento', array('class' => 'control-label')) !!}
						<div class="col-lg-12 col-md-12 col-sm-12">
							{!! Form::select('tipodocpersona', ["DNI" => "DNI" , "RUC" => "RUC"], "DNI",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tipodocpersona')) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4 form-group">
						{!! Form::label('nrodocumento', 'Nro. Documento', array('class' => 'control-label')) !!}
						<div class="col-lg-12 col-md-12 col-sm-12">
							{!! Form::text('nrodocumento', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'nrodocumento')) !!}
						</div>
					</div>
					<div class="col-8 form-group">
						{!! Form::label('remitente', 'Nombre', array('class' => 'control-label')) !!}
						<div class="col-lg-12 col-md-12 col-sm-12">
							{!! Form::text('remitente', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'remitente')) !!}
						</div>
					</div>
					
				</div>
				</div>
			</div>
		{{-- FIN DATOS DEL SOLICITANTE --}}
				
		</div>
		<div class="col-6">
			{{-- DATOS DEL EXPEDIENTE --}}
			<div class="card card-primary" >
				<div class="card-header">
					<h5 class="card-title">DATOS DEL EXPEDIENTE</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col form-group">
							{!! Form::label('numero', 'Número', array('class' => 'control-label')) !!}
							<div class="col-lg-12 col-md-12 col-sm-12">
								{!! Form::text('numero', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'numero' , 'readonly' => true)) !!}
							</div>
						</div>
						<div class="col form-group">
							{!! Form::label('tipodoctramite', 'Tipo documento', array('class' => 'control-label')) !!}
							<div class="col-lg-12 col-md-12 col-sm-12">
								{!! Form::select('tipodoctramite', $tipodocumento, "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'tipodoctramite')) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-10 form-group">
							{!! Form::label('asunto', 'Asunto', array('class' => 'control-label')) !!}
							<div class="col-lg-12 col-md-12 col-sm-12">
								{!! Form::text('asunto', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'asunto')) !!}
							</div>
						</div>
						<div class="col-2 form-group">
							{!! Form::label('folios', 'Folios', array('class' => 'control-label')) !!}
							<div class="col-lg-12 col-md-12 col-sm-12">
								{!! Form::number('folios',  null ,array('class' => 'form-control form-control-sm input-xs', 'id' => 'folios')) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('observacion', 'Observación', array('class' => 'control-label')) !!}
						<div class="col-lg-12 col-md-12 col-sm-12">
						{!! Form::textarea('observacion', null,array('class' => 'form-control form-control-sm input-xs', 'id' => 'observacion', "rows"=>2 , "style"=>"resize:none;")) !!}
						</div>
					</div>
				</div>
			</div>
			{{-- FIN DATOS DEL EXPEDIENTE --}}
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
	configurarAnchoModal('1100');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
}); 
</script>