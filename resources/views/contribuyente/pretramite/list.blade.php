@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<style>
.estado.bg-error{
	background-color: rgb(209, 62, 62);
	color: white;
}	
</style>
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
		@php
		$estado_class = '';
		$fecha_aceptado_rechazado ='-';
			if($value->estado == 'PENDIENTE'){
				$estado_class = 'bg-warning';
			}else if ($value->estado == 'ACEPTADO'){
				$estado_class = 'bg-success';
				$fecha_aceptado_rechazado = $value->fecha_aceptado;
			}else if($value->estado =='RECHAZADO'){
				$estado_class = 'bg-error';
				$fecha_aceptado_rechazado = $value->fecha_rechazado;
			}else if($value->estado =='CREADO'){
				$estado_class = 'bg-primary';
				$fecha_aceptado_rechazado = $value->fecha_creado;
			}
		@endphp
        <tr >
			<td>{{ $contador }}</td>
			<td>{{ $value->numero}}</td>
			<td>{{ $value->created_at}}</td>
			<td>{{ $fecha_aceptado_rechazado}}</td>
			<td>{{ $value->tramite?$value->tramite->numero:''}}</td>
			<td>{{ $value->remitente}}</td>
			<td class="estado {{$estado_class}}">{{ $value->estado}}</td>
            <td>{!! Form::button('<div class="fas fa-eye"></div> Detalles', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-primary')) !!}</td>
            @if ($value->estado == 'PENDIENTE')
			<td>
				<div class="btn-group">
					{!! Form::button('<div class="fas fa-thumbs-up"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["aceptar"], array($value->id, 'SI')).'\', \''.$titulo_aceptar.'\', this);', 'class' => 'btn btn-sm btn-success', 'title'=>'aceptar')) !!}
					{!! Form::button('<div class="fas fa-thumbs-down"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["rechazar"], array($value->id, 'SI')).'\', \''.$titulo_rechazar.'\', this);', 'class' => 'btn btn-sm btn-danger', 'title'=>'rechazar')) !!}
				</div>	
			</td>
			@elseif ($value->estado == 'ACEPTADO')
			<td>
				{!! Form::button('<div class="fas fa-arrow-right"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["crear"], array($value->id, 'SI')).'\', \''.$titulo_aceptar.'\', this);', 'class' => 'btn btn-sm btn-success', 'title'=>'crear trámite')) !!}
			</td>
			@endif
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