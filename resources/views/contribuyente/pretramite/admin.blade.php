<!-- Content Header (Page header) -->
<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tramites modalidad virtual</div>
                
                <div class="card-body">
                    <div >
                        {!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'w-100  mt-3', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
                        {!! Form::hidden('page', 1, array('id' => 'page')) !!}
                        {!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
                        

						<div class="row w-100">
							<div class="col-lg-3 col-md-3  form-group">
								{!! Form::label('fechainicio', 'Fecha inicio') !!}
								{!! Form::date('fechainicio', date('Y-m-d'), array('class' => 'form-control input-xs', 'id' => 'fechainicio' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>
							<div class="col-lg-3 col-md-3  form-group">
								{!! Form::label('fechafin', 'Fecha fin') !!}
								{!! Form::date('fechafin', '', array('class' => 'form-control input-xs', 'id' => 'fechafin' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>	
							<div class="col-lg-3 col-md-3  form-group">
								{!! Form::label('numero', 'Numero') !!}
								{!! Form::text('numero', '', array('class' => 'form-control ', 'id' => 'numero')) !!}
							</div>
							<div class="col-lg-3 col-md-3  form-group">
								{!! Form::label('estado', 'Estado') !!}
								{!! Form::select('estado',["" => 'Todos' , 'PENDIENTE' => 'Pendiente', 'ACEPTADO' => 'Aceptado', 'RECHAZADO' =>' Rechazado'],'', array('class' => 'form-control ', 'id' => 'estado' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>						
						</div>
						<div class="row w-100">
							<div class="col-lg-3 col-md-3  form-group">
								{!! Form::label('remitente', 'Remitente') !!}
								{!! Form::text('remitente', '', array('class' => 'form-control ', 'id' => 'remitente')) !!}
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
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="numero"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="remitente"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
	});
			if('{{$cerrar}}' == 'S'){
				cerrarModal(contadorModal-1);
			}
</script>
{{--  --}}
