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
			<td>{{ $value->tipodocumento->descripcion }}</td>
			<td>{{ $value->asunto }}</td>
			<td>{{ $value->tipo }}</td>
			<td>{{ $value->areaorigen() }}</td>
			{{-- <td>{{ $value->areaactual() }}</td> --}}
			<td>{{ $value->remitente}}</td>
			<td>
				<div class="btn-group">
					@switch($modo)
						@case('entrada')
							@if($value->situacion == 'DERIVADO' || $value->situacion == 'REGISTRADO')
							{!! Form::button('<div class="fas fa-thumbs-up"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'aceptar')).'\', \''."Aceptar trámite".'\', this);', 'class' => 'btn btn-sm btn-primary', 'title' => 'Aceptar')) !!}
							{!! Form::button('<div class="fas fa-times"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'rechazar')).'\', \''."Rechazar trámite".'\', this);', 'class' => 'btn btn-sm btn-danger', 'title' => 'rechazar')) !!}
							@endif
							@break
						@case('bandeja')
							@if($value->situacion == 'EN PROCESO')
								{!! Form::button('<div class="fas fa-pencil-alt"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-sm btn-info', 'title' => 'Editar')) !!}
								{!! Form::button('<div class="fas fa-times"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'listar'=>'SI', 'accion'=>'rechazar')).'\', \''."Rechazar Trámite".'\', this);', 'class' => 'btn btn-sm btn-danger', 'title' => 'Rechazar')) !!}
								{!! Form::button('<div class="fas fa-file-alt"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'adjuntar')).'\', \''."Adjuntar Archivo".'\', this);', 'class' => 'btn btn-sm btn-warning', 'title' => 'Adjuntar')) !!}
								{!! Form::button('<div class="fas fa-check"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'finalizar')).'\', \''."Finalizar Tramite".'\', this);', 'class' => 'btn btn-sm btn-success', 'title' => 'Finalizar')) !!}
							@endif
							@if($value->situacion == 'EN PROCESO' || $value->situacion == 'REGISTRADO')
								{!! Form::button('<div class="fas fa-arrow-right"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'derivar')).'\', \''.'Derivar trámite'.'\', this);', 'class' => 'btn btn-sm btn-default', 'title' => 'Derivar')) !!}
							@endif
							@break
						@case('salida')
							@break
						@case('archivos')						
						{!! Form::button('<div class="fas fa-file-alt"> </div> ', array('onclick' => 'modal (\''.URL::route($ruta["confirmacion"], array($value->id, 'SI', 'accion'=>'archivar')).'\', \''."Asignar archivador a documento".'\', this);', 'class' => 'btn btn-sm btn-warning', 'title' => 'Asignar archivador')) !!}
						@foreach ($value->seguimientos as $item)
							@if (!is_null($item->ruta))
								<a href="{{asset($item->ruta)}}" target="_blank"> 
									<button class="btn btn-sm btn-info" title="Descargar Archivo">
										<i class="fas fa-file-download"></i>
									</button>
								</a>
							@endif
						@endforeach
						@break
						@default
						@break
					@endswitch
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