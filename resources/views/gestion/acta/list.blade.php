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
			<td>{{ date_format(date_create($value->fecha ), 'd/m/Y')}}</td>
			<td>{{ $value->numero }}</td>
			<td>{{ $value->subgerencia }}</td>
			<td>{{ $value->ordenanza }}</td>
			<td>
				@if ($value->imagen)
					<a href="{{asset('storage\archivos2\\'.$value->imagen)}}"  target="_blank" >{{ $value->imagen }}</a>
				@else
					-
				@endif
			</td>
			<td>
				<div class="btn-group">
					{!! Form::button('<div class="fas fa-edit"></div> Editar', array('title'=>'EDITAR', 'onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-warning')) !!}
					{{-- {!! Form::button('<div class="fas fa-file-pdf"></div> Pdf', array('onclick' =>'pdf(\''.$value->id.'\')', 'class' => 'btn btn-sm btn-primary')) !!} --}}
					{!! Form::button('<div class="fas fa-trash"></div> Eliminar', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-sm btn-danger')) !!}
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
		window.open( 'acta/pdf/'+id , '_blank');
	}
</script>