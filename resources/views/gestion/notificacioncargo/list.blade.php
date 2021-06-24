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
		@php
			$dia_notificacion = new DateTime($value->fecha_notificacion);
			$today = new DateTime("now");
			$diff = $dia_notificacion->diff($today);
			
		@endphp
        <tr>
			<td>{{ $contador }}</td>
			<td>{{ $diff->days }}</td>
			<td>{{ $value->fecha_inspeccion }}</td>
			<td>{{ $value->fecha_notificacion }}</td>
			<td>{{ $value->nombre }}</td>
			<td>{{ $value->p_nombre }}</td>
			<td>{{ number_format($value->i_monto,2) }}</td>
			<td>{{ $value->actafiscalizacion ? $value->actafiscalizacion->numero : '-' }}</td>
			<td>{{ $value->infraccion ? $value->infraccion->codigo : '-' }}</td>
			<td>{{ $value->estado =='RESOLUCION' ? 'PARA RESOLUCION' : $value->estado}}</td>
			<td>
				<div class="btn-group">
					@if ($value->estado == 'PENDIENTE')
					{!! Form::button('<div class="fas fa-edit"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning' , 'title' => 'Editar')) !!}
					@endif
					@if($diff->days < 6 && ($value->estado == 'PENDIENTE' || $value->estado == 'CON DESCARGO'))
						{!! Form::button('<div class="fas fa-comment"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["descargo"], array($value->id, 'SI')).'\', \''.$titulo_descargo.'\', this);', 'class' => 'btn btn-sm btn-primary' , 'title' => 'Descargo')) !!}
					@endif
					@if ($value->estado != 'ARCHIVADO' && $value->estado != 'RESOLUCION')
					{!! Form::button('<div class="fa fa-paper-plane"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["resolucion"], array($value->id, 'SI')).'\', \''.$titulo_resolucion.'\', this);', 'class' => 'btn btn-sm btn-success' , 'title' => 'Resolucion')) !!}
					@endif
					@if ($diff->days < 15 && $value->estado != 'ARCHIVADO')
					{!! Form::button('<div class="fa fa-archive"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["archivar"], array($value->id, 'SI')).'\', \''.$titulo_resolucion.'\', this);', 'class' => 'btn btn-sm btn-default' , 'title' => 'Archivar')) !!}
					@endif
					</div>
			</td>
			 
			<td>
				<div class="btn-group">
					{!! Form::button('<div class="fas fa-file-pdf"></div>', array('onclick' =>'pdf(\''.$value->id.'\')', 'class' => 'btn btn-sm btn-primary')) !!}</>
					{!! Form::button('<div class="fas fa-route"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["seguimiento"], array($value->id, 'NO')).'\', \''.$titulo_seguimiento.'\', this);', 'class' => 'btn btn-sm btn-secondary' , 'title' => 'Seguimiento')) !!}
					{!! Form::button('<div class="fas fa-trash"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger' , 'title' => 'Eliminar')) !!}
				 </div>
			</td>
				
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