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
			<td>{{ date_format(date_create($value->fechaexpedicion), 'd/m/Y')}}</td>
			<td>{{ $value->numero }}</td>
			<td>{{ $value->tipotramite->descripcion }}</td>
			<td>{{ $value->contribuyente }}</td>
			@if (!is_null($value->dni) && $value->dni!='')
				<td>{{$value->dni}}</td>
			@else
				<td>{{$value->ruc}}</td>
			@endif
			<td>{{ ($value->ordenpago) ? $value->ordenpago->numero : '-' }}</td>
			<td>{{ ($value->inspeccion) ? $value->inspeccion->numero : '-' }}</td>
            <td>
				<div class="btn-group">
					{!! Form::button('<div class="fas fa-edit"></div>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning')) !!}
					<a href="{{route('resolucion.pdfResolucion', $value->id)}}" target="_blank">
						<button class="btn btn-sm btn-primary" title="FORMATO PDF">
							<i class="fas fa-file-pdf"></i> 
						</button>
					</a>
					@if ($value->tipo_id=='3')
					<a href="{{route('resolucion.pdfResolucion', ['id'=>$value->id, 'blanco'=>'si'])}}" target="_blank">
						<button class="btn btn-sm btn-secondary" title="FORMATO CARTILLA">
							<i class="fas fa-file-word"></i> 
						</button>
					</a>
					@endif
					{!! Form::button('<div class="fas fa-trash"></div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}
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