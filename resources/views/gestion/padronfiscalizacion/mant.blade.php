<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($padronfiscalizacion, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<legend class=" font-weight-bold" style="font-size: 1rem">IDENTIFICACION DEL ESTABLECIMIENTO</legend>
	<div class="row ">
		<div class="col-2 form-group">
			{!! Form::label('fecha', 'Fecha*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::date('fecha', date('Y-m-d'), array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fecha')) !!}
			</div>
		</div>
		<div class="col-2 form-group">
			{!! Form::label('numero', 'Número*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('numero', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'numero')) !!}
			</div>
		</div>		
		<div class="col-sm form-group">
			{!! Form::label('fiscalizador', 'Responsable del llenado del Formato*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('fiscalizador', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'fiscalizador')) !!}
			</div>
		</div>	
		<div class="form-group col-sm">
			{!! Form::label('file', 'Archivo*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::file('file', null, array('class' => 'form-control-file form-control-sm input-xs', 'id' => 'file' )) !!}
			</div>
		</div>	
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('ruc', 'RUC', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
				<div class="col-lg-10 col-md-10 col-sm-10">
					{!! Form::text('ruc', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'ruc')) !!}
				</div>
				<div class="col-lg-1 col-sm-1 col-md-1 pl-1">
					{!! Form::button('<i class="fa fa-search "></i>', array('class' => 'btn btn-primary', 'title' => 'Buscar RUC' , 'id' => 'botonBuscarRuc')) !!}
				</div>
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('razonsocial', 'Razon Social', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('razonsocial', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'razonsocial')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('rubro', 'Rubro*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('rubro', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'rubro')) !!}
			</div>
		</div>		
	</div>
	<div class="row">
		<div class="form-group col-4">
			{!! Form::label('representantelegal', 'Representante Legal*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('representantelegal', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'representantelegal')) !!}
			</div>
		</div>
		@if ($padronfiscalizacion)
            <div class="col-2 form-group">
                {!! Form::label('tipopersona', 'Tipo de persona*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipopersona', 'P/NAT', $padronfiscalizacion->tipopersona == 'P/NAT' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="P/NAT">P/NAT</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipopersona', 'JUR', $padronfiscalizacion->tipopersona == 'JUR' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="JUR">JUR</label>
                    </div>
                </div>
            </div>
        @else
            <div class="col-2 form-group">
                {!! Form::label('tipopersona', 'Tipo de persona*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipopersona', 'P/NAT', false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="P/NAT">P/NAT</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipopersona', 'JUR', true, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="JUR">JUR</label>
                    </div>
                </div>
            </div>
        @endif
		<div class="form-group col-3">
			{!! Form::label('telefono', 'Teléfono/Celular', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::number('telefono', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'telefono')) !!}
			</div>
		</div>
		<div class="form-group col-3">
			{!! Form::label('correo', 'Email', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::email('correo', null, array('class' => 'form-control form-control-sm input-xs', 'id' => 'correo')) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-6">
			{!! Form::label('direccion', 'Dirección Completa*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lbldireccion']) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('direccion', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'direccion']) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('urbanizacion', 'Urb.', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblurbanizacion']) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('urbanizacion', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'urbanizacion']) !!}
			</div>
		</div>
		<div class="form-group col-2">
			{!! Form::label('sector', 'Sector', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblsector']) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('sector', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'sector']) !!}
			</div>
		</div>
		<div class="form-group col-1">
			{!! Form::label('manzana', 'Mz.', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblmanzana']) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('manzana', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'manzana']) !!}
			</div>
		</div>
		<div class="form-group col-1">
			{!! Form::label('lote', 'Lte.', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lbllote']) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('lote', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'lote']) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm form-group">
			{!! Form::label('tamano', 'Tamaño de la Empresa*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('tamano',$cboTamanos, null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'tamano' , 'onchange' => '')) !!}
			</div>
		</div>
		<div class="col-sm form-group">
			{!! Form::label('condicion', 'Condición del Establecimiento Comercial', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('condicion',$cboCondiciones, null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'condicion' , 'onchange' => '')) !!}
			</div>
		</div>
	</div>
	@if ($padronfiscalizacion)
		@php
			$idArray = explode('-', $padronfiscalizacion->formalizacion);
			$vigencia1 = explode('/', $padronfiscalizacion->vigencia1);
			$vigencia2 = explode('/', $padronfiscalizacion->vigencia2);
			$vigencia3 = explode('/', $padronfiscalizacion->vigencia3);
			$vigencia4 = explode('/', $padronfiscalizacion->vigencia4);
			$vigencia5 = explode('/', $padronfiscalizacion->vigencia5);
		@endphp
		<div class="row container p-1">
			{!! Form::label('tipotramitesolicitud', 'Cuenta con:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-sm">
					<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE LICENCIA DE FUNCIONAMIENTO" id="formalizacion1" <?php if(in_array('CERTIFICADO DE LICENCIA DE FUNCIONAMIENTO',$idArray)) echo "checked" ;?>> CERTIFICADO DE LICENCIA DE FUNCIONAMIENTO <br/>
					<div class="row d-none" id="vigencia1">
						<div class="col-sm">
							<input type="text" class="form-control form-control-sm" name="entramite1" value="{{$vigencia1[2]}}" placeholder="Llenar si está en trámite">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="desde1" id="desde1" value="{{$vigencia1[0]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="hasta1" id="hasta1" value="{{$vigencia1[1]}}">
						</div>
					</div>
					<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE DEFENSA CIVIL" id="formalizacion2" <?php if(in_array('CERTIFICADO DE DEFENSA CIVIL',$idArray)) echo "checked" ;?>> CERTIFICADO DE DEFENSA CIVIL <br/>
					<div class="row d-none" id="vigencia2">
						<div class="col-sm">
							<input type="text" class="form-control form-control-sm" name="entramite2" placeholder="Llenar si está en trámite" value="{{$vigencia2[2]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="desde2" id="desde2" value="{{$vigencia2[0]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="hasta2" id="hasta2" value="{{$vigencia2[1]}}">
						</div>
					</div>
					<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE SALUBRIDAD" id="formalizacion3" <?php if(in_array('CERTIFICADO DE SALUBRIDAD',$idArray)) echo "checked" ;?>> CERTIFICADO DE SALUBRIDAD<br/>
					<div class="row d-none" id="vigencia3">
						<div class="col-sm">
							<input type="text" class="form-control form-control-sm" name="entramite3" placeholder="Llenar si está en trámite" value="{{$vigencia3[2]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="desde3" id="desde3" value="{{$vigencia3[0]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="hasta3" id="hasta3" value="{{$vigencia3[1]}}">
						</div>
					</div>
					<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE FUMIGACION" id="formalizacion4" <?php if(in_array('CERTIFICADO DE FUMIGACION',$idArray)) echo "checked" ;?>> CERTIFICADO DE FUMIGACION <br/>
					<div class="row d-none" id="vigencia4">
						<div class="col-sm">
							<input type="text" class="form-control form-control-sm" name="entramite4" placeholder="Llenar si está en trámite" value="{{$vigencia4[2]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="desde4" id="desde4" value="{{$vigencia4[0]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="hasta4" id="hasta4" value="{{$vigencia4[1]}}">
						</div>
					</div>
					<input type="checkbox" name="formalizacion[]" value="OTROS" id="formalizacion5" <?php if(in_array('OTROS',$idArray)) echo "checked" ;?>> OTROS <br/>
					<div class="row d-none" id="vigencia5">
						<div class="col-sm">
							<input type="text" class="form-control form-control-sm" name="otrostxt" placeholder="Especificar Otros" value="{{$idArray[count($idArray)-1]}}">
						</div>
						<div class="col-sm">
							<input type="text" class="form-control form-control-sm" name="entramite5" placeholder="Llenar si está en trámite" value="{{$vigencia5[2]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="desde5" id="desde5" value="{{$vigencia5[0]}}">
						</div>
						<div class="col-sm">
							<input type="date" class=" form-control form-control-sm" name="hasta5" id="hasta5" value="{{$vigencia5[1]}}">
						</div>
					</div>
				</div>
		</div>
	@else
	<div class="row container p-1">
		{!! Form::label('tipotramitesolicitud', 'Cuenta con:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-sm">
				<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE LICENCIA DE FUNCIONAMIENTO" id="formalizacion1"> CERTIFICADO DE LICENCIA DE FUNCIONAMIENTO <br/>
				<div class="row d-none" id="vigencia1">
					<div class="col-sm">
						<input type="text" class="form-control form-control-sm" name="entramite1" placeholder="Llenar si está en trámite">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="desde1" id="desde1">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="hasta1" id="hasta1">
					</div>
				</div>
				<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE DEFENSA CIVIL" id="formalizacion2"> CERTIFICADO DE DEFENSA CIVIL <br/>
				<div class="row d-none" id="vigencia2">
					<div class="col-sm">
						<input type="text" class="form-control form-control-sm" name="entramite2" placeholder="Llenar si está en trámite">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="desde2" id="desde2">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="hasta2" id="hasta2">
					</div>
				</div>
				<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE SALUBRIDAD" id="formalizacion3"> CERTIFICADO DE SALUBRIDAD<br/>
				<div class="row d-none" id="vigencia3">
					<div class="col-sm">
						<input type="text" class="form-control form-control-sm" name="entramite3" placeholder="Llenar si está en trámite">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="desde3" id="desde3">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="hasta3" id="hasta3">
					</div>
				</div>
				<input type="checkbox" name="formalizacion[]" value="CERTIFICADO DE FUMIGACION" id="formalizacion4"> CERTIFICADO DE FUMIGACION <br/>
				<div class="row d-none" id="vigencia4">
					<div class="col-sm">
						<input type="text" class="form-control form-control-sm" name="entramite4" placeholder="Llenar si está en trámite">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="desde4" id="desde4">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="hasta4" id="hasta4">
					</div>
				</div>
				<input type="checkbox" name="formalizacion[]" value="OTROS" id="formalizacion5"> OTROS <br/>
				<div class="row d-none" id="vigencia5">
					<div class="col-sm">
						<input type="text" class="form-control form-control-sm" name="otrostxt" placeholder="Especificar Otros">
					</div>
					<div class="col-sm">
						<input type="text" class="form-control form-control-sm" name="entramite5" placeholder="Llenar si está en trámite">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="desde5" id="desde5">
					</div>
					<div class="col-sm">
						<input type="date" class=" form-control form-control-sm" name="hasta5" id="hasta5">
					</div>
				</div>
			</div>
	</div>
	@endif
	<legend class=" font-weight-bold" style="font-size: 1rem">PUBLICIDAD</legend>
	<div class="row">
		<div class="form-group col-sm">
			{!! Form::label('tipoanuncio', 'Tipo de Anuncio', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('tipoanuncio', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'tipoanuncio', 'placeholder'=>'Simple o Luminoso')) !!}
			</div>
		</div>
		<div class="form-group col-sm">
			{!! Form::label('tamanoanuncio', 'Tamaño del Anuncio', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::text('tamanoanuncio', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'tamanoanuncio')) !!}
			</div>
		</div>
	</div>
	<legend class=" font-weight-bold" style="font-size: 1rem">AL PROPIETARIO</legend>
	@if ($padronfiscalizacion)
		@php
			$idArray = explode('-', $padronfiscalizacion->alpropietario);
		@endphp
		<div class="row container p-1">
			{!! Form::label('tipotramitesolicitud', 'Cuenta con:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-sm">
					<input type="checkbox" name="alpropietario[]" value="LICENCIAS DE CONSTRUCCION" id="alpropietario1" <?php if(in_array('LICENCIAS DE CONSTRUCCION',$idArray)) echo "checked" ;?> > LICENCIAS DE CONSTRUCCION <br/>
					<input type="checkbox" name="alpropietario[]" value="LICENCIAS DE DEMOLICION" id="alpropietario2" <?php if(in_array('LICENCIAS DE DEMOLICION',$idArray)) echo "checked" ;?>> LICENCIAS DE DEMOLICION <br/>
					<input type="checkbox" name="alpropietario[]" value="INSTALACIONES DE ANTENAS" id="alpropietario3" <?php if(in_array('INSTALACIONES DE ANTENAS',$idArray)) echo "checked" ;?>> INSTALACIONES DE ANTENAS<br/>
					<input type="checkbox" name="alpropietario[]" value="OTROS" id="alpropietario4" <?php if(in_array('OTROS',$idArray)) echo "checked" ;?>> OTROS <br/>
					<input type="text" class="form-control form-control-sm d-none" name="alpropietario[]" id="inpuOtros" placeholder="Especificar Otros" value="{{$idArray[count($idArray)-1]}}">
				</div>
		</div>
	@else
	<div class="row container p-1">
		{!! Form::label('tipotramitesolicitud', 'Cuenta con:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-sm">
				<input type="checkbox" name="alpropietario[]" value="LICENCIAS DE CONSTRUCCION" id="alpropietario1"> LICENCIAS DE CONSTRUCCION <br/>
				<input type="checkbox" name="alpropietario[]" value="LICENCIAS DE DEMOLICION" id="alpropietario2"> LICENCIAS DE DEMOLICION <br/>
				<input type="checkbox" name="alpropietario[]" value="INSTALACIONES DE ANTENAS" id="alpropietario3"> INSTALACIONES DE ANTENAS<br/>
				<input type="checkbox" name="alpropietario[]" value="OTROS" id="alpropietario4"> OTROS <br/>
				<input type="text" class="form-control form-control-sm d-none" name="alpropietario[]" id="inpuOtros" placeholder="Especificar Otros">
			</div>
	</div>
	@endif
	<legend class=" font-weight-bold" style="font-size: 1rem">OBSERVACIONES</legend>
	<div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::textarea('observaciones', null, array('class' => 'form-control form-control-sm  input-xs', 'id' => 'observaciones','rows'=>3 , 'style' =>'resize:none;')) !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'type' => 'submit')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {

	configurarAnchoModal('1000');
	init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	@if (!$padronfiscalizacion)
		generarNumero();
	@endif
	toggleOtros();

	$('input[type=checkbox][id=formalizacion1]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#vigencia1').removeClass('d-none');
		}else{
			$('#vigencia1').addClass('d-none');
		}
	});
	$('input[type=checkbox][id=formalizacion2]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#vigencia2').removeClass('d-none');
		}else{
			$('#vigencia2').addClass('d-none');
		}
	});
	$('input[type=checkbox][id=formalizacion3]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#vigencia3').removeClass('d-none');
		}else{
			$('#vigencia3').addClass('d-none');
		}
	});
	$('input[type=checkbox][id=formalizacion4]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#vigencia4').removeClass('d-none');
		}else{
			$('#vigencia4').addClass('d-none');
		}
	});
	$('input[type=checkbox][id=formalizacion5]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#vigencia5').removeClass('d-none');
		}else{
			$('#vigencia5').addClass('d-none');
		}
	});
	$('input[type=checkbox][id=alpropietario4]').change(function(e){
		var val=e.target.checked;
		if(val){
			$('#inpuOtros').removeClass('d-none');
		}else{
			$('#inpuOtros').addClass('d-none');
		}
	});

	$( IDFORMMANTENIMIENTO + '{{ $entidad }}').submit(function( event ) {
			event.preventDefault();
			var idformulario = IDFORMMANTENIMIENTO + '{{ $entidad }}';
			var entidad = "{{$entidad}}";
			var formData = new FormData($(this)[0]);
			var respuesta = '';
			var listar       = 'NO';
			if ($(idformulario + ' :input[id = "listar"]').length) {
				var listar = $(idformulario + ' :input[id = "listar"]').val();
			};
			var request = $.ajax({
			url     : $(this).attr('action'),
			method  : "POST",
			data    : formData,
			processData: false,  
			contentType: false,
			});
			request.done(function(msg) {
				respuesta = msg;
				console.log('eeeee');
			}).fail(function(jqXHR, textStatus) {
				respuesta = 'ERROR';
			}).always(function(){
				if(respuesta.trim() === 'ERROR'){
				}else {
					if (respuesta.trim() === 'OK') {
						console.log('eeee');
						cerrarModal();
						Hotel.notificaciones("Accion realizada correctamente", "Realizado" , "success");
						if (listar.trim() === 'SI') {							
							buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
						}        
					} else {
						mostrarErrores(respuesta, idformulario, entidad);
					}
				}
			}); 
    	});
	 
	$('#botonBuscarRuc').on('click', function(){
		buscarRUC();
	});

	function toggleOtros(){
		if ($('#formalizacion1').is(":checked")){
			$('#vigencia1').removeClass('d-none');
		}
		if ($('#formalizacion2').is(":checked")){
			$('#vigencia2').removeClass('d-none');
		}
		if ($('#formalizacion3').is(":checked")){
			$('#vigencia3').removeClass('d-none');
		}
		if ($('#formalizacion4').is(":checked")){
			$('#vigencia4').removeClass('d-none');
		}
		if ($('#formalizacion5').is(":checked")){
			$('#vigencia5').removeClass('d-none');
		}
		if ($('#alpropietario4').is(":checked")){
			$('#inpuOtros').removeClass('d-none');
		}
	}

	function buscarRUC(){
		var reg = new RegExp('^[0-9]+$');
		if($(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val() == ""){
			toastr.warning("Debe ingresar un RUC.", 'Error:');
		}else if(!reg.test($(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val())){
			toastr.warning("El RUC ingresado es incorrecto.", 'Error:');
		}else{
			$.ajax({
				type: "POST",
				url: "empresacourier/buscarRUC",
				data: "ruc="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val()+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
				beforeSend(){
				alert("Consultando...");
				},
				success: function(a) {
					datos=JSON.parse(a);
					if(datos.length == 0){
						toastr.warning("El RUC ingresado es incorrecto.", 'Error:');
					}else{
						$("#razonsocial").val(datos.RazonSocial);
						$("#direccion").val(datos.Direccion);
					}
				}
			});
		}
	}


}); 	

	function generarNumero(){
		$.ajax({
			type: "POST",
			url: "{{route('padronfiscalizacion.generarnumero')}}",
			data: "_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +"&tipo=" +$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo_id"]').val(),
			success: function(a) {
				$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
			}
		});
	}
</script>
