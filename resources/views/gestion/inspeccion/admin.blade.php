<!-- Content Header (Page header) -->
<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Inspeccion</div>
                
                <div class="card-body">
                    <div >
                        {!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'w-100  mt-3', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
                        {!! Form::hidden('page', 1, array('id' => 'page')) !!}
                        {!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
                        

						<div class="row w-100">
							<div class="col-lg-4 col-md-4  form-group">
								{!! Form::label('numero_search', 'Numero') !!}
								{!! Form::text('numero_search', '', array('class' => 'form-control ', 'id' => 'numero_search')) !!}
							</div>
							<div class="col-lg-4 col-md-4  form-group">
								{!! Form::label('fechainicio', 'Fecha inicio') !!}
								{!! Form::date('fechainicio', date('Y-m-d'), array('class' => 'form-control input-xs', 'id' => 'fechainicio' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>
							<div class="col-lg-4 col-md-4  form-group">
								{!! Form::label('fechafin', 'Fecha fin') !!}
								{!! Form::date('fechafin', '', array('class' => 'form-control input-xs', 'id' => 'fechafin' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>							
						</div>
						<div class="row w-100">
							<div class="col-lg-4 col-md-4  form-group">
								{!! Form::label('tipo', 'Tipo') !!}
								{!! Form::select('tipo', $tipostramite,'', array('class' => 'form-control ', 'id' => 'tipo' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>
							<div class="col-lg-2 col-md-2  form-group" style="min-width: 150px;">
								{!! Form::label('nombre', 'Filas a mostrar') !!}
								{!! Form::selectRange('filas', 1, 30, 10, array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>							
						</div>
                        
                        {!! Form::close() !!}
					</div>
                   
                      <div class="row mt-2" >
						<div class="col-md-12">
						  <div class="card">
							<div class="card-header">
							  <div class="card-tools">
								{!! Form::button(' <i class="fa fa-plus fa-fw"></i> Agregar', array('class' => 'btn  btn-outline-primary', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}
		   					</div>
							<span class="badge badge-success">ACEPTADO</span>
								<span class="badge badge-danger">RECHAZADO</span>
								<span class="badge badge-primary">NOTIFICADO</span>
								<span class="badge badge-warning">OBSERVADO</span>
								{{-- <span class="badge badge-secondary">SIN RESPUESTA</span> --}}
							</div>
							<div class="btn-group">
								<span class="btn btn-warning btn-sm">
									<i class="fas fa-edit"></i> Editar
								</span>
								<span class="btn btn-primary btn-sm">
									<i class="fas fa-file-pdf"></i> PDF
								</span>
								<span class="btn btn-danger btn-sm">
									<i class="fas fas fa-trash"></i> Eliminar
								</span>
								<span class="btn btn-info btn-sm">
									<i class="fas fa-envelope"></i> Notificar
								</span>
								<span class="btn btn-secondary btn-sm">
									<i class="fas fa-check-double"></i> Levantar observaciones
								</span>
							</div>
							<!-- /.card-header -->
							<div class="card-body table-responsive px-3">
								<div id="listado{{ $entidad }}">
								</div>
							</div>
							<!-- /.card-body -->
						  </div>
						  <!-- /.card -->
						</div>
					  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
		buscar('{{ $entidad }}');
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="numero_search"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
		
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="tipo"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
	});
</script>
{{--  --}}