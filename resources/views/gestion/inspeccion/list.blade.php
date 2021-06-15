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
		@switch($value->estado)
			@case('ACEPTADO')
				<?php
				$color = "success";	
				?>
				@break
			@case('RECHAZADO')
				<?php
				$color = "danger";	
				?>
				@break
			@case('OBSERVADO')
				<?php
				$color = "warning";	
				?>
				@break
			@case('NOTIFICADO')
				<?php
				$color = "primary";	
				?>
				@break
			@default
				<?php
				$color = "";	
				?>
				@break;
		@endswitch
        <tr>
			<td>{{ $contador }}</td>
			<td>{{ date_format(date_create($value->fecha ), 'd/m/Y')}}</td>
			<td>
				<span class="{{'badge badge-' .$color}}">
					{{ $value->numero }}
				</span>
			</td>
			<td>{{ $value->tipotramite->descripcion }}</td>
			<td>{{ $value->descripcion }}</td>
			<td>
				<a href="{{asset('storage\archivos2\\'.$value->archivo)}}"  target="_blank" >{{ $value->archivo }}</a>
			</td>
			<td>
				<div class="btn-group">
					{!! Form::button('<div class="fas fa-edit"></div>', array('title'=>'EDITAR', 'onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning')) !!}
          			<a href="{{route('inspeccion.pdfInspeccion', $value->id)}}" target="_blank">
						<button class="btn btn-sm btn-primary" title="PDF">
							<i class="fas fa-file-pdf"></i> 
						</button>
					</a>
					{!! Form::button('<div class="fas fa-trash"></div>', array('title'=>'ELIMINAR','onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}
					@if (($value->tipo_id == '1' || $value->tipo_id == '4') && $value->estado == 'OBSERVADO')
						{!! Form::button('<div class="fas fa-envelope"></div>', array('title'=>'GENERAR NOTIFICACIÓN' , 'onclick' => 'modal (\''.URL::route("carta.create", array($value->id, 'listar'=>'SI', 'id_inspeccion'=>$value->id)).'\', \''.'Generar Carta de Notificación de Inspeccion Nro.' . $value->numero . ' - ' . $value->tipotramite->descripcion . '\', this);', 'class' => 'btn btn-sm btn-info')) !!}
					@endif
					@if ($value->estado=='NOTIFICADO')
					{{-- {{dd($value->carta->last()->estado)}} --}}
					{!! Form::button('<div class="fas fa-check-double"></div>', array('title'=>'LEVANTAR OBSERVACIONES' , 'onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI', 'observacion'=>'SI')).'\', \''.'Levantar Observaciones de Inpescción Nro.' . $value->numero . '- ' . $value->tipotramite->descripcion .'\', this);', 'class' => 'btn btn-sm btn-secondary')) !!}
					@endif
				</div>
            <td>
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
