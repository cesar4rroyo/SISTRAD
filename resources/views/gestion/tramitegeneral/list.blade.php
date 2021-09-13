@if(count($lista) == 0)
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
		$modo = "general";
		?>
		@foreach ($lista as $key => $value)
		
			
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
			<td>{{ str_pad($value->id, 6, "0", STR_PAD_LEFT) }}</td>
			@php
                $siglas = $value->seguimientos[0]->areas ? $value->seguimientos[0]->areas->siglas : '';
			@endphp
			<td>{{ $value->tipodocumento->descripcion . " N° " .$value->numero . "-MDJLO/" . $siglas }}</td>
			{{-- <td>{{ $value->tipodocumento->descripcion }}</td> --}}
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
					<a href={{"tramite/ticket/pdf/?ticket=" . $value->id}} target="_blank"> 
						<button class="btn btn-sm btn-info" title="Imprimir">
							<i class="fas fa-print"></i>
						</button>
					</a>
				</div>
           </td>
		   	<td>{!! Form::button('<div class="fas fa-route"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'seguimiento')).'\', \''.'Seguimiento del trámite'.'\', this);', 'class' => 'btn btn-sm btn-secondary', 'title' => 'Ver Seguimiento')) !!}</td>
			{{-- <td>{!! Form::button('<div class="fas fa-trash"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}</td> --}}
		</tr>
		<?php
		$contador = $contador + 1;
		?>
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
	$('a#divtotalregistros').text('TOTAL DE REGISTROS  '+{{count($lista)}});
</script>
