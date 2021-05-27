<!-- Content Header (Page header) -->

<div class="container" id="container">

    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-8 col-offset-2">
            <div class="card">
                <div class="card-header">Reporte pagos</div>
                
                <div class="card-body">
                    <div class="row">
                        {!! Form::open(['route' => 'reporteordenpago.pdfordenespago', 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'w-100  mt-3', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
                        {!! Form::hidden('page', 1, array('id' => 'page')) !!}
                        {!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
                        
                        <div class="row">
                          <div class="col-md-6 form-group">
                            {!! Form::label('fechainicio', 'Fecha inicio') !!}
                            {!! Form::date('fechainicio', date('Y-m-d'), array('class' => 'form-control input-xs', 'id' => 'fechainicio' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                          </div>
                          <div class="col-md-6 form-group">
                            {!! Form::label('fechafin', 'Fecha fin') !!}
                            {!! Form::date('fechafin', '', array('class' => 'form-control input-xs', 'id' => 'fechafin' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                          </div>
                        </div>
                        <div class="col-lg-12 col-md-12  form-group">
                          {!! Form::label('tipo', 'Tipo') !!}
                          {!! Form::select('tipo', $tipostramite,'', array('class' => 'form-control ', 'id' => 'tipo' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                        </div>
                        <div class="col-lg-12 col-md-12  form-group">
                          {!! Form::label('subtipo', 'Subtipo') !!}
                          {!! Form::select('subtipo', $subtipostramite,'', array('class' => 'form-control ', 'id' => 'subtipo' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                        </div>
                        <div class="col-lg-3 col-md-3  form-group">
                          {!! Form::label('estado', 'Estado') !!}
                          {!! Form::select('estado',["" => 'Todos' , 'pendiente' => 'Pendiente', 'confirmado' => 'Confirmado'],'', array('class' => 'form-control ', 'id' => 'estado' ,'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                        </div>	
                          <div class="col-lg-12 col-md-12 form-group text-center pt-4">
                            {!! Form::button('GENERAR REPORTE <i class="fa fa-file ml-2"></i> ', array('class' => 'btn btn-primary   ', 'id' => 'btnDetalle', 'onclick' => 'imprimirpdf();' ,'style'=>'width:60%;')) !!}   
                          </div>
                        {!! Form::close() !!}
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
 
<script type="text/javascript">
    $(document).ready(function ()  {
		    init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
	});

        function imprimirpdf(){
            window.open("reporteordenpago/pdfordenespago?tipo="+$("#tipo").val()+"&fechainicio="+$("#fechainicio").val()+"&fechafin="+$("#fechafin").val()+"&estado="+$("#estado").val()+"&subtipo="+$("#subtipo").val(),"_blank");
        }
</script>
