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
			<td>{{ $value->numero }}</td>
			<td>{{ $value->fecha_inspeccion }}</td>
			<td>{{ $value->fecha_notificacion }}</td>
			<td>{{ $value->nombre }}</td>
			<td>{{ $value->p_nombre }}</td>
			<td>{{ number_format($value->i_monto,2) }}</td>
			<td>{{ $value->actafiscalizacion ? $value->actafiscalizacion->numero : '-' }}</td>
			<td>{{ $value->infraccion ? $value->infraccion->codigo : '-' }}</td>
            <td>{!! Form::button('<div class="fas fa-file-pdf"></div>', array('onclick' =>'pdf(\''.$value->id.'\')', 'class' => 'btn btn-sm btn-primary')) !!}</td>
            <td>{!! Form::button('<div class="fas fa-edit"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning')) !!}</td>
			<td>{!! Form::button('<div class="fas fa-trash"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}</td>
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
<script>
	function pdf(id){
		window.open( 'notificacioncargo/pdf/'+id , '_blank');
	}
</script>