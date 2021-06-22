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
			$color = null;
			if($value->estado!='REGISTRADO' && $value->estado!='FINALIZADO' && $value->estado!='COACTIVA'){
				$today=date('d/m/Y');
				if(strtotime($today)>=strtotime($value->fechafin)){
					$color = 'bg-warning';
				}
			}
			

		@endphp
		
        <tr class="{{($color) ? $color : ''}}">
			<td>{{ $contador }}</td>
			<td>{{ date_format(date_create($value->fechaemision ), 'd/m/Y')}}</td>
			<td>{{ $value->numero }}</td>
			<td>{{ $value->estado }}</td>
			<td>{{ $value->ordenanza }}</td>
			<td>{{ $value->actafiscalizacion->numero }}</td>
			<td>{{ $value->notificacion->numero }}</td>
			<td>
				<div class="btn-group">
					@if ($color)
						{!! Form::button('<div class="fas fa-envelope"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'listar'=>'SI', 'accion'=>'coactiva')).'\', \''.'Enviar a Coactiva'.'\', this);', 'class' => 'btn btn-sm btn-light')) !!}
					@endif
					@if ($value->estado==='REGISTRADO')
						{!! Form::button('<div class="fas fa-check-double"></div>', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'entregar')).'\', \''.'Entregar Resolución'.'\', this);', 'class' => 'btn btn-sm btn-default')) !!}
						{!! Form::button('<div class="fas fa-edit"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning')) !!}
					@endif
					@if ($value->estado==='ENTREGADO' && is_null($color))
						{!! Form::button('<div class="fas fa-money-bill"></div>', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'pagar')).'\', \''.'Pagar Deuda'.'\', this);', 'class' => 'btn btn-sm btn-success')) !!}
						{!! Form::button('<div class="fas fa-minus-circle"></div>', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'archivar')).'\', \''.'Archivar Resolución'.'\', this);', 'class' => 'btn btn-sm btn-dark')) !!}
					@endif
					@if ($value->estado!='REGISTRADO')
						{!! Form::button('<div class="fas fa-pencil-alt"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'listar'=>'SI', 'accion'=>'comentar')).'\', \''."Descargo".'\', this);', 'class' => 'btn btn-sm btn-info', 'title' => 'Comentar')) !!} 
					@endif
					{!! Form::button('<div class="fas fa-file-pdf"></div> ', array('onclick' =>'pdf(\''.$value->id.'\')', 'class' => 'btn btn-sm btn-primary')) !!}
					{!! Form::button('<div class="fas fa-trash"></div> ', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}
					{!! Form::button('<div class="fas fa-route"> </div>', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'seguimiento')).'\', \''.'Seguimiento del trámite'.'\', this);', 'class' => 'btn btn-sm btn-secondary', 'title' => 'Ver Seguimiento')) !!}
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
		console.log(id);
		window.open( 'resolucionsancion/pdf/'+id , '_blank');
	}
</script>