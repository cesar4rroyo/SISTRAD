<!-- Content Header (Page header) -->


@extends("theme.$theme.layout")

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bienvenido, {{session()->get('nombres') ?? 'Invitado'}} ({{session()->get('area')['area']['descripcion'] ?? 'Admin'}})</div>
                
                <div class="card-body">
                    <div class="row">
                        {!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'w-100 d-md-flex d-lg-flex d-sm-inline-block mt-3', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
                        {!! Form::hidden('page', 1, array('id' => 'page')) !!}
                        {!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
                        
                        <input type="hidden" name="modo" id="modo" value="general">
                        
						<div class="row w-100">
							<div class="col-lg-4 col-md-4  form-group">
								{!! Form::label('numero', 'Numero') !!}
								{!! Form::text('numero', '', array('class' => 'form-control ', 'id' => 'numero')) !!}
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
                      </div>
					  <div class="row">
						<div class="row w-100">
							<div class="col-lg-4 col-md-4  form-group">
								{!! Form::label('tipos', 'Tipo de Trámite') !!}
								{!! Form::select('tipos', $cboTipoTramite, "",array('class' => 'form-control form-control input-xs', 'id' => 'tipos', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
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
								<span class="badge badge-success">FINALIZADO</span>
								<span class="badge badge-danger">RECHAZADO</span>
								<span class="badge badge-primary">FINALIZADO CON OBSERVACION</span>
								<span class="badge badge-warning">RECHAZADO AREA ANTERIOR</span>

							</div>
							<!-- /.card-header -->
							<div class="card-body table-responsive px-3">
								@include('gestion.tramite.tabla')
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
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
		buscar('{{ $entidad }}');
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="numero"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="tipos"]').change(function (e) {
			buscar('{{ $entidad }}');
		});
	});
</script>
{{--  --}}