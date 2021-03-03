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
		?>
		@foreach ($lista as $key => $value)
        <tr>
			<td>{{ $contador }}</td>
			<td>{{ $value->prioridad }}</td>
			<td>{{ date_format(date_create($value->fecha),  'd/m/Y') }}</td>
			<td>{{ $value->numero }}</td>
			<td>{{ $value->asunto }}</td>
			<td>{{ $value->tipo }}</td>
			<td>{{ $value->areaorigen() }}</td>
			<td>{{ $value->areaactual() }}</td>
			<td>{{ $value->situacion}}</td>
			<td>
				<div class="btn-group">
					@if($value->situacion == 'POR ACEPTAR')
						{!! Form::button('<div class="fas fa-thumbs-up"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-primary', 'title' => 'aceptar')) !!}
					@endif
					@if($value->situacion == 'ACEPTADO' || $value->situacion == 'REGISTRADO')
						{!! Form::button('<div class="fas fa-arrow-right"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-default', 'title' => 'derivar')) !!}
						@endif
						@if($value->situacion == 'ACEPTADO')
						{!! Form::button('<div class="fas fa-times"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-danger', 'title' => 'rechazar')) !!}
						{!! Form::button('<div class="fas fa-check"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-success', 'title' => 'finalizar')) !!}
					@endif
				</div>
           </td>
		   <td>{!! Form::button('<div class="fas fa-route"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-secondary', 'title' => 'ver ruta')) !!}</td>
			<td>{!! Form::button('<div class="fas fa-trash"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}</td>
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