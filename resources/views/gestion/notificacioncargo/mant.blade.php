
<style>
	.input-table{
		width: 100px;
	}
</style>
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($notificacioncargo, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	{!! Form::hidden('listInfracciones', $listar, array('id' => 'listInfracciones')) !!}
	<div class="row">
		<div class="col-3 form-group">
			{!! Form::label('numero', 'Número *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'numero')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('nro_ordenanza', 'N° Ordenanza', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nro_ordenanza', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'nro_ordenanza')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('fecha_inspeccion', 'Fecha inspeccion *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha_inspeccion', $notificacioncargo?(date_format(date_create($notificacioncargo->fecha_inspeccion) , 'Y-m-d')): date('Y-m-d'), array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fecha_inspeccion')) !!}
			</div>
		</div>
		<div class="col-3 form-group">
			{!! Form::label('fecha_notificacion', 'Fecha notificación *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha_notificacion', $notificacioncargo?(date_format(date_create($notificacioncargo->fecha_notificacion ), 'Y-m-d')): date('Y-m-d'), array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fecha_notificacion')) !!}
			</div>
		</div>
		
	</div>
	<!--  DATOS INFRACTOR-->

	<label class="mt-1" style="color: gray;">DATOS DEL INFRACTOR</label>
	<div class="row">

		<div class=" col-6 form-group">
			{!! Form::label('nro_documento', 'DNI/RUC/C.I/C.E *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="input-group" style="padding-left:10px;">
				{!! Form::text('nro_documento', null, array('class' => 'form-control form-control-sm input-sm ', 'id' => 'nro_documento' , 'onkeypress'=>'return filterFloat(event,this)')) !!}
				<span class="input-group-btn">
					{!! Form::button('<i class="fa fa-search" id="ibtnConsultar"></i>', array('style'=>'background:#00a8cc; color:white; height:30px;','class'=> 'btn  waves-effect waves-light  btn-sm', 'id' => 'btnConsultar')) !!}
				</span>
			</div>
		</div>

		<div class="col-6 form-group">
			{!! Form::label('nombre', 'Nombre/Razón social *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nombre', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'nombre')) !!}
			</div>
		</div>
	</div>

	<div class="row ">
		{!! Form::label('direccion', 'Direccion infractor *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-4 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('calle', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'calle' , 'placeholder' => 'CALLE/AV/JR/PSJE')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('nro', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'nro' , 'placeholder' => 'Nro')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('sector', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'sector', 'placeholder' => 'Sector')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('manzana', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'manzana', 'placeholder' => 'Mz.')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('lote', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'lote' , 'placeholder' => 'Lt.')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('urbanizacion', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'urbanizacion' , 'placeholder' => 'Urbanizacion')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('distrito', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'distrito' , 'placeholder' => 'Distrito')) !!}
			</div>
		</div>
	</div>

	<label class="mt-1" style="color: gray;">DATOS DEL PERSONAL A CARGO DE LA INFRACCIÓN</label>
	<div class="row">
		<div class=" col-6 form-group">
			{!! Form::label('p_nro_documento', 'DNI/RUC/C.I/C.E *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="input-group" style="padding-left:10px;">
				{!! Form::text('p_nro_documento', null, array('class' => 'form-control form-control-sm input-sm ', 'id' => 'p_nro_documento' , 'onkeypress'=>'return filterFloat(event,this)')) !!}
				<span class="input-group-btn">
					{!! Form::button('<i class="fa fa-search" id="ibtnConsultar2"></i>', array('style'=>'background:#00a8cc; color:white; height:30px;','class'=> 'btn  waves-effect waves-light  btn-sm', 'id' => 'btnConsultar2')) !!}
				</span>
			</div>
		</div>
		<div class="col-6 form-group">
			{!! Form::label('p_nombre', 'Nombre/Razón social *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('p_nombre', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'p_nombre')) !!}
			</div>
		</div>
	</div>
	
	<label class="ml-2 mt-3" >LUGAR INFRACCIÓN *</label>
	<!--  LUGAR INFRACCION-->
	<div class="row">
		<div class="col-4 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_calle', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_calle' , 'placeholder' => 'CALLE/AV/JR/PSJE')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_nro', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_nro' , 'placeholder' => 'Nro')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_sector', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_sector', 'placeholder' => 'Sector')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_manzana', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_manzana', 'placeholder' => 'Mz.')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_lote', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_lote' , 'placeholder' => 'Lt.')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_urbanizacion', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_urbanizacion' , 'placeholder' => 'Urbanizacion')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('i_distrito', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'i_distrito' , 'placeholder' => 'Distrito')) !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-3 form-group">
			{!! Form::label('actafiscalizacion_id', 'Acta de fiscalización', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('actafiscalizacion_id',$actas, ($notificacioncargo)?$notificacioncargo->actafiscalizacion_id:null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'actafiscalizacion_id' , 'onchange' => '')) !!}
			</div>
		</div>
		<div class="col-6 form-group">
			{!! Form::label('infraccion_id', 'Infracción *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				<select class="form-control form-control-sm  input-xs" name="infraccion_id" id="infraccion_id">
					<option value="" selected>Seleccione</option>
					@foreach ($infracciones as $infraccion)
					<option class="opt-infraccion" codigo = "{{$infraccion->codigo}}" monto ="{{$infraccion->uit}}"  value="{{$infraccion->id}}">{{$infraccion->codigo.' - '.$infraccion->descripcion}}</option>
					@endforeach
				</select>
			</div>
		</div>
		
		<div class="col-2 form-group">
			{!! Form::label('uit', 'UIT*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('uit', $uit, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'uit')) !!}
			</div>
		</div>
	</div>


	{{-- TAbla --}}
		<div class="row my-3">
			<div class="col-md-10 offset-md-1" >
				<table class="table table-bordered table-sm ">
					<thead>
						<tr>
							<th>Infraccion</th>
							<th>UIT</th>
							<th>% UIT</th>
							<th>Monto</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody id='table_detalle'>
					</tbody>
					<tfoot>
						<td colspan="3" class="text-right "><b>TOTAL</b></td>
						<td ><input type="number" class="form-control form-control-sm input-xs" id='total' name='total' value="0.0" readonly></td>
					</tfoot>
				</table>
			</div>
		</div>

	{{-- FIN TAbla --}}

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción detallada de los hechos *', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('descripcion', null, array('class' => 'form-control form-control-sm form-control form-control-sm-sm  input-xs', 'id' => 'descripcion','rows'=>3 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	
    <div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => '$(\'#listInfracciones\').val(carro);guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
	configurarAnchoModal('1000');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	$('#i_monto').inputmask('decimal', { rightAlign: false , digits:2  });
});


	$('#btnConsultar').on('click', function(){
		let valor = $('#nro_documento').val();
				if(valor.length == 8){
					consultarDNI(valor,1);
				}else if (valor.length == 11){
					consultaRUC(valor,1);
				}else{
					alert('Ingrese un documento válido');
				}
	});
	$('#btnConsultar2').on('click', function(){
		let valor = $('#p_nro_documento').val();
				if(valor.length == 8){
					consultarDNI(valor , 2);
				}else if (valor.length == 11){
					consultaRUC(valor , 2);
				}else{
					alert('Ingrese un documento válido');
				}
	});
	 
	 var carro = new Array();
	function verificarExistencia(id){
		for (let i = 0; i < carro.length; i++) {
			if(carro[i] == id){
				return true;
			}
		}
		return false;
	}

	$('#infraccion_id').on('change', function(){
		let uit = $('#uit').val();
		uit = parseFloat(uit);
		let porcentaje =	$('#infraccion_id option:selected').attr('monto');
		let codigo =	$('#infraccion_id option:selected').attr('codigo');
		let id =	$('#infraccion_id').val();
		console.log(id);
		if(porcentaje && uit){
			let monto = parseFloat(porcentaje)*parseFloat(uit);
			monto = monto.toFixed(2);
			let existe = verificarExistencia(id);
			if(!existe){
				agregarDetalle(id , uit,codigo, porcentaje, monto);
				
			}else{
				console.log('ya existe');
			}
			
		}else{
			alert('Seleccione una infraccion e ingrese el monto de una UIT');
		}
	});

	function eliminarFila(id){
		$('#tr'+id).remove();
		for (let i = 0; i < carro.length; i++) {
			if(carro[i] == id){
				carro.splice(i,1);
			}
			
		}
		calcularTotal();
	}

	function agregarDetalle(id, uit,codigo, porcentaje, monto){
		var tr = `<tr id='tr${id}'>
							<td>${codigo}</td>
							<td><input type="number" id="uit${id}" name='uit${id}' class="input-table form-control form-control-sm  input-xs" value='${uit}'  onblur='calcularTotal();'></td>
							<td><input type="number" id="porcentaje${id}" name='porcentaje${id}' class="input-table form-control form-control-sm  input-xs" value='${porcentaje}' onblur='calcularTotal();'></td>
							<td><input type="number" readonly id='monto${id}' name ='monto${id}' class='input-table form-control form-control-sm  input-xs' value='${monto}'></td>
							<td><button type='button' class="btn btn-danger" onclick='eliminarFila(${id});' ><i class="fa fa-trash"></i></button></td>
						</tr>`;
				carro.push(id);
				$('#table_detalle').append(tr);
				calcularTotal();
	}

	function calcularTotal(){
		var total = 0.0;
		for (let i = 0; i < carro.length; i++) {
			const id= carro[i];
			var uit = parseFloat( $('#uit'+id).val());
			var porcentaje = parseFloat($('#porcentaje'+id).val());
			var monto = (uit*porcentaje).toFixed(2);

			$('#monto'+id).val(monto);
			total = parseFloat(total) + parseFloat(monto);
		}

		$('#total').val( parseFloat(total).toFixed(2));
	}

	$('#btn_agregar').on('click', function(){
		let infraccion 	=	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="infraccion_id"]').val();
		let monto 		=	$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="i_monto"]').val();
		if(infraccion && monto){
			let tr = '';
		}else{
			alert('Ingrese un monto y seleccione una infracción');
		}
	});

	function consultarDNI(dni , id){
// 
		$.ajax({
			type: "POST",
			url: "{{route('ordenpago.buscarDNI')}}",
			data: "dni="+dni+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
			success: function(a) {
				datos=JSON.parse(a);
				if(id == 1){
					$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="nombre"]').val(datos.nombres+' '+datos.apepat+' '+datos.apemat);
				}else{
					$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="p_nombre"]').val(datos.nombres+' '+datos.apepat+' '+datos.apemat);
				}
			}
		});
	}
	function consultaRUC(ruc, id){
		$.ajax({
			type: "POST",
			url: "{{route('ordenpago.buscarRUC')}}",
			data: "ruc="+ruc+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
			success: function(a) {
				datos=JSON.parse(a);
				if(datos.length == 0){
					toastr.error('El DNI o RUC ingresado es incorrecto', 'Error');
				}else{
					if(id == 1){
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="nombre"]').val(datos.RazonSocial);
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="calle"]').val(datos.Direccion);
					}else{
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="p_nombre"]').val(datos.RazonSocial);
						$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="p_calle"]').val(datos.Direccion);
					}
				}
			}
		});
	}
		
</script>
@if ($notificacioncargo)
@foreach($notificacioncargo->detalles as $detalle)
<?php
	$id = $detalle->infraccion_id;
	$uit = $detalle->uit;
	$codigo = $detalle->infraccion->codigo;
	$porcentaje = $detalle->porcentaje;
	$monto = number_format($uit*$porcentaje,2);
?>

<script>
	agregarDetalle('{{$id}}','{{$uit}}','{{$codigo}}','{{$porcentaje}}','{{$monto}}');
</script>
@endforeach>
@endif




