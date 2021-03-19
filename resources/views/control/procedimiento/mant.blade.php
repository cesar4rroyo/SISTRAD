<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($procedimiento, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('listAreas', null, array('id' => 'listAreas')) !!}

	<div class="row">
		<div class="col-6">
			<div class="form-group">
				{!! Form::label('nombre', 'Descripción', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion')) !!}
				</div>
			</div>
			{{-- <div class="form-group">
				{!! Form::label('plazo', 'Plazo (dias)', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('plazo', $procedimiento?$procedimiento->plazo : 1, array('class' => 'form-control input-xs', 'id' => 'plazo', 'placeholder' => 'Ingrese la descripción' , "min" => 1)) !!}
				</div>
			</div> --}}
			<div class="form-group">
				{!! Form::label('nombre', 'Observación', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::textarea('observacion', null, array('class' => 'form-control input-xs', 'id' => 'observacion' ,"rows" => 2 , "style" => "resize: none;")) !!}
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="px-3">
				<table class="table table-bordered table-sm px-2 table-striped " id ="tablaAreas">
					<legend>Recorrido areas</legend>
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12">
							{!! Form::select('areainicio_id', $areas , $procedimiento?$procedimiento->areainicio_id: "", array('class' => 'form-control input-xs', 'id' => 'areainicio_id')) !!}
						</div>
					</div>
					<thead>
						<tr>
							<th>Area</th>
							<th>Plazo</th>
							<th>Quitar</th>
						</tr>
					</thead>	
					<tbody>
		
					</tbody>
				</table>
			</div>
		</div>
	</div>

	
	
	
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar',  'onclick' => '$(\'#listAreas\').val(JSON.stringify(carro_areas)); guardarTramite(\''.$entidad.'\', this);')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}

<style>
	.select2-container--default .select2-selection--single {
			  border: 1px solid #ced4da;
			  padding: .46875rem .75rem;
			  height: calc(2.25rem + 2px);
	  }
</style>
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('900');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

	$('#areainicio_id').select2();
	$('#areafin_id').select2();

	$("select[name=areainicio_id]").change(function(){
		var idarea = $(this).val();
		if(idarea == "" || !idarea) {
			return false;
		}

        var nombre = $('select[name=areainicio_id] option:selected').text();
		var plazo = prompt("Ingrese el plazo:");

		if(!isNaN(plazo) && plazo != null && plazo != ""){
			seleccionarArea(idarea , nombre , plazo);
  		}else{
			  toastr.error('Debe ingresar un numero');
		  }
    });
}); 

	var carro_areas = new Array();

	function seleccionarArea(idarea , nombre, plazo){
		var detalle = `<tr id="tr${idarea}">
							<td width ="80%">${nombre}</td>
							<td width ="15%"><input value="${plazo}" type="number" style="width:80px;" id="plazo${idarea}" name="plazo${idarea}"></td>
							<td width ="5%"><a href='#' onclick="quitarDetalle('${idarea}');"><i class='fa fa-minus-circle ' title='Quitar' width='20px' height='20px'></i></td>
						</tr>`;
		
		var area = {"idarea" : idarea, "plazo" : plazo};
		carro_areas.push(area);
		$("#tablaAreas").append(detalle);
	}

	function quitarDetalle(idarea){
		$("#tr"+idarea).remove();
		
		for(c=0; c < carro_areas.length; c++){
            if(carro_areas[c]["idarea"] == idarea) {
                carro_areas.splice(c,1);
            }
        }
	}

	function guardarTramite(entidad , boton){
		if(carro_areas.length < 1){
			toastr.warning("Debes indicar al menos un área" , "");
		}else{
			guardar(entidad, boton);
		}
	}

</script>

@if(!is_null($procedimiento))
	@foreach ($procedimiento->rutas as $ruta)
		<script>
			seleccionarArea('{{$ruta->areainicial_id}}' , '{{$ruta->areainicio->descripcion}}'+'{{$ruta->orden}}' , '{{$ruta->plazo}}');
		</script>		
	@endforeach
@endif