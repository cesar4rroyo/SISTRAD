@php $x = 0 ; @endphp

@foreach ($lista as $value)
	@php
	$ultimo_seguimiento = $value->latestSeguimiento;
	$accion             = strtoupper($ultimo_seguimiento->accion);
	$area               = $ultimo_seguimiento->area_id;
	$penultimo_seguimiento = $value->seguimientos;
	if(count($penultimo_seguimiento)>=2){
		$penultimo_seguimiento = $value->seguimientos[count($penultimo_seguimiento)-2];
	}
	if( $area_id && $area_id != ""){
		if( $modo == 'entrada'){
			if(($accion == 'DERIVAR' && $area == $area_id )){
				$value->cumple = 'S';
			}else if (($accion == 'REGISTRAR' && $area == $area_id)) {
				$value->cumple = 'S';
			}else{
				$value->cumple = 'N';
				$x++;
			}

		}else if($modo == 'salida'){ 
			if(($accion != 'REGISTRAR' && $accion != 'ACEPTAR' && $accion != 'ADJUNTAR' && $accion!='COMENTAR')){ // EN EL METODO LISTAR DEL MODELO YA SE HA VERIFICADO QUE TENGA TENGO AL MENOS UN SEGUIMIENTO CON EL AREA_ID DEL USUARIO
				if($accion=='DERIVAR'){
					if($ultimo_seguimiento->area == $area_actual){
						$value->cumple = 'S';
					}else{
						$value->cumple = 'N';
						$x++;
					}
				}
				if($accion=='FINALIZAR'){
					if($penultimo_seguimiento->accion=='RECHAZAR' && $penultimo_seguimiento->area_id==$area_id){
						$value->cumple = 'S';
					}else if($penultimo_seguimiento->accion!='RECHAZAR' && $penultimo_seguimiento->area_id==$area_id){
						$value->cumple = 'S';						
					}else{
						$value->cumple = 'N';
						$x++;
					}
				}else{
					$value->cumple = 'S';
				}	
				
			}else {
				$value->cumple = 'N';
				$x++;
			}
		}else if($modo == 'bandeja'){
			if (($accion == 'ACEPTAR' || $accion=='ADJUNTAR' || $accion=='COMENTAR') && $area == $area_id) {
				$value->cumple = 'S';
			}else {
				$value->cumple = 'N';
				$x++;
			}
		}else if($modo == 'general'){
			$value->cumple = 'S';
		}else if($modo == 'archivos'){
			if($area != $area_id || $area==$area_id){
				$existe=false;
				foreach ($value->seguimientos as $item) {
					if(!is_null($item->ruta)){
						$existe=true;
						break;
					}
				}
				if($existe){
					$value->cumple = 'S';
				}else{
					$value->cumple = 'N';
					$x++;
				}
			}else{
				$value->cumple = 'N';
				$x++;
			}
		}else {
			$value->cumple = 'N';
			$x++;
		}
	}	
	@endphp
@endforeach

@if(count($lista) - $x == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<table id="example1" class="table table-bordered table-striped table-condensed table-hover">
	<thead>
		<tr>
			@foreach($cabecera as $key => $value)
				<th @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		<?php
		$contador = $inicio + 1;
		?>
		@foreach ($lista as $key => $value)
		
			
		@if($value->cumple == 'S')
		@switch($value->situacion)
			@case('FINALIZADO')
				<?php
				$color = "bg-success";	
				?>
				@break
			@case('RECHAZADO')
				<?php
				$color = "bg-danger";	
				?>
				@break
			@case('RECHAZADO AREA ANTERIOR')
				<?php
				$color = "bg-warning";	
				?>
				@break
			@case('FINALIZADO CON OBSERVACION')
				<?php
				$color = "bg-primary";	
				?>
				@break
			@default
				<?php
				$color = "";	
				?>
				@break;
		@endswitch
		@switch($value->prioridad)
			@case('ALTA')
				<?php
				$prioridad = "badge-danger";	
				?>
				@break
			@case('NORMAL')
				<?php
				$prioridad = "badge-primary";	
				?>
				@break
			@case('BAJA')
				<?php
				$prioridad = "badge-warning";	
				?>
				@break				
		@endswitch
        <tr class="{{($color) ? $color : ''}}">
			<td>{{ $contador }}</td>
			<td>
				<span class="badge {{$prioridad}}">
					{{ $value->prioridad }}
				</span>
			</td>
			<td>{{ date_format(date_create($value->fecha),  'd/m/Y') }}</td>
			<td>{{ $value->numero }}</td>
			<td>{{ $value->tipodocumento->descripcion }}</td>
			<td>{{ $value->asunto }}</td>
			<td>
				{{ $value->tipo }}
				@if ($value->tipo == 'TUPA')
					<span>({{$value->procedimiento->descripcion}})</span>
				@endif
			</td>
			<td>{{ $value->areaorigen() }}</td>
			{{-- <td>{{ $value->areaactual() }}</td> --}}
			<td>{{ $value->remitente}}</td>
			<td>
				<div class="btn-group">
					@switch($modo)
						@case('entrada')
							@if($value->situacion == 'DERIVADO' || $value->situacion == 'REGISTRADO' || $value->situacion=='RECHAZADO AREA ANTERIOR')
							{!! Form::button('<div class="fas fa-thumbs-up"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'aceptar')).'\', \''."Aceptar trámite".'\', this);', 'class' => 'btn btn-sm btn-primary', 'title' => 'Aceptar')) !!}
							{!! Form::button('<div class="fas fa-times"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'rechazar')).'\', \''."Rechazar trámite".'\', this);', 'class' => 'btn btn-sm btn-danger', 'title' => 'rechazar')) !!}
							@endif
							@break
						@case('bandeja')
							@if($value->situacion == 'EN PROCESO')
								{!! Form::button('<div class="fas fa-pencil-alt"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'listar'=>'SI', 'accion'=>'comentar')).'\', \''."Comentar".'\', this);', 'class' => 'btn btn-sm btn-info', 'title' => 'Comentar')) !!} 
								{!! Form::button('<div class="fas fa-times"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'listar'=>'SI', 'accion'=>'rechazar')).'\', \''."Rechazar Trámite".'\', this);', 'class' => 'btn btn-sm btn-danger', 'title' => 'Rechazar')) !!}
								{!! Form::button('<div class="fas fa-file-alt"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'adjuntar')).'\', \''."Adjuntar Archivo".'\', this);', 'class' => 'btn btn-sm btn-warning', 'title' => 'Adjuntar')) !!}
								@if ($value->tipo == 'TUPA')
									@if (count($value->procedimiento->rutas) == $value->procedimiento->rutaActual($area_id))
										{!! Form::button('<div class="fas fa-check"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'finalizar')).'\', \''."Finalizar Tramite".'\', this);', 'class' => 'btn btn-sm btn-success', 'title' => 'Finalizar')) !!}
									@endif
								@else
									{!! Form::button('<div class="fas fa-check"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'finalizar')).'\', \''."Finalizar Tramite".'\', this);', 'class' => 'btn btn-sm btn-success', 'title' => 'Finalizar')) !!}
								@endif
							@endif
							@if($value->situacion == 'EN PROCESO' || $value->situacion == 'REGISTRADO')
								@if ($value->tipo == 'TUPA')
									@if (count($value->procedimiento->rutas) != $value->procedimiento->rutaActual($area_id))
										{!! Form::button('<div class="fas fa-arrow-right"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'derivar')).'\', \''.'Derivar trámite'.'\', this);', 'class' => 'btn btn-sm btn-default', 'title' => 'Derivar')) !!}
									@endif
								@else
									{!! Form::button('<div class="fas fa-arrow-right"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'derivar')).'\', \''.'Derivar trámite'.'\', this);', 'class' => 'btn btn-sm btn-default', 'title' => 'Derivar')) !!}
								@endif
							@endif
							@break
						@case('salida')
							@break
						@case('archivos')						
						{!! Form::button('<div class="fas fa-file-alt"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'archivar')).'\', \''."Asignar archivador a documento".'\', this);', 'class' => 'btn btn-sm btn-warning', 'title' => 'Asignar archivador')) !!}
						@foreach ($value->seguimientos as $item)
							@if (!is_null($item->ruta))
								<a href="{{asset($item->ruta)}}" target="_blank"> 
									<button class="btn btn-sm btn-info" title="Descargar Archivo">
										<i class="fas fa-file-download"></i>
									</button>
								</a>
							@endif
						@endforeach
						@break
						@default
						@break
					@endswitch
				</div>
           </td>
		   	<td>{!! Form::button('<div class="fas fa-route"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'seguimiento')).'\', \''.'Seguimiento del trámite'.'\', this);', 'class' => 'btn btn-sm btn-secondary', 'title' => 'Ver Seguimiento')) !!}</td>
			{{-- <td>{!! Form::button('<div class="fas fa-trash"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}</td> --}}
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endif
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			@foreach($cabecera as $key => $value)
				<th @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</tfoot>
</table>
{!! $paginacion!!}
@endif
<script >
	$('a#divtotalregistros').text('TOTAL DE REGISTROS  '+{{count($lista)- $x}});
</script>
