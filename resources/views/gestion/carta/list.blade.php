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
			if((date('d/m/Y')>=date_format(date_create($value->fechalimite ), 'd/m/Y')) && $value->aviso=='NOTIFICACION'){
				if($value->inspeccion->estado == 'NOTIFICADO'){
					$color = 'bg-warning';
				}
			}else{
				$color = null;
			}
		@endphp
        <tr class="{{($color) ? $color : ''}}">
			<td>{{ $contador }}</td>
			<td>{{ date_format(date_create($value->fechainicial ), 'd/m/Y')}}</td>
			<td>{{ date_format(date_create($value->fechalimite ), 'd/m/Y')}}</td>
			<td>{{ $value->plazo }}</td>
			<td>{{ $value->numero }}</td>
			<td>{{ $value->tipotramite->descripcion }}</td>
			<td>{{ $value->destinatario }}</td>
			<td>{{ $value->asunto }}</td>
			<td>
				<div class="btn-group">
					{!! Form::button('<div class="fas fa-file-pdf"></div> Pdf', array('onclick' =>'pdf(\''.$value->id.'\')', 'class' => 'btn btn-sm btn-primary')) !!}
					{!! Form::button('<div class="fas fa-trash"></div> Eliminar', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}
					@if ($color)
						{!! Form::button('<div class="fas fa-envelope"></div>Notificar', array('title'=>'GENERAR NOTIFICACIÓN', 'onclick' => 'modal (\''.URL::route("carta.create", array($value->id, 'listar'=>'SI', 'id_inspeccion'=>$value->inspeccion->id, 'entidad'=>'carta')).'\', \''.'Generar Carta de Notificación Ref Doc. '. $value->inspeccion->numero . ' - ' . $value->inspeccion->tipotramite->descripcion .'\', this);', 'class' => 'btn btn-sm btn-info')) !!}
					@endif
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
		window.open( 'carta/pdf/'+id , '_blank');
	}
</script>