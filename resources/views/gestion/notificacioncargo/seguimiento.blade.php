

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($modelo, $formData) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

    <table width='100%;' class="table table-bordered">
        <tr>
            <th>ACCION</th>
            <th>FECHA</th>
            <th>DESCRIPCION</th>
            <th>ARCHIVO</th>
        </tr>
        <tr >
            <td class="bg-default">NUEVO</td>
            <td>{{$modelo->created_at}}</td>
            <td>-</td>
            <td>-</td> 
        </tr>
        @foreach ($modelo->descargos as $descargo)
        <tr>
            <td class="bg-primary">DESCARGO</td>
            <td>{{$descargo->created_at}}</td>
            <td>{{$descargo->descripcion}}</td>
            <td>				
                <a href="{{asset('storage\archivos2\\'.$descargo->archivo)}}"  target="_blank" >ver archivo</a>
            </td>

        </tr> 
        @endforeach
        <tr>
            <td class="bg-success">RESOLUCION</td>
            <td>{{$modelo->fecha_resolucion}}</td>
            <td>-</td>
            <td>-</td> 
        </tr>
        <tr>
            <td class="bg-secondary">ARCHIVADO</td>
            <td>{{$modelo->fecha_archivado}}</td>
            <td>-</td>
            <td>-</td> 
        </tr>
    </table>
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-undo "></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal((contadorModal - 1));')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		configurarAnchoModal('1000');
	});
</script>