<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($resolucion, $formData) !!}
{!! Form::hidden('listar', $listar, ['id' => 'listar']) !!}
{!! Form::hidden('toggletipo', $toggletipo, ['id' => 'toggletipo']) !!}
@if ($resolucion)
    @if ($resolucion->tipo_id == '1')
	<meta name="csrf-token" content="{{ csrf_token() }}">
		<input type="hidden" value="{{$resolucion->id}}" id="bajaid" name="bajaid">
        <div class="row float-lg-right">
			<button class="btn btn-danger btn-sm" onclick="funBaja();">Dar Baja</button>
        </div>
        <br>
    @endif
@endif
<div class="row ">
    <div class="col-4 form-group">
        {!! Form::label('fechaexpedicion', 'Fecha de Expedición*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::date('fechaexpedicion', $resolucion ? date_create($resolucion->fechaexpedicion) : date('Y-m-d'), ['class' => 'form-control  input-xs', 'id' => 'fechaexpedicion']) !!}
        </div>
    </div>
    <div class="col-4 form-group" id="divFechaVencimiento">
        {!! Form::label('fechavencimiento', 'Fecha de Vencimiento*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::date('fechavencimiento', $resolucion ? date_create($resolucion->fechavencimiento) : null, ['class' => 'form-control  input-xs', 'id' => 'fechavencimiento']) !!}
        </div>
    </div>
    <div class="col-4 form-group">
        {!! Form::label('tipo_id', 'Tipo*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::select('tipo', $tipostramite, $toggletipo, ['class' => 'form-control  input-xs', 'id' => 'tipo_id', 'onchange' => 'generarNumero(); cambiarsubtipos();']) !!}
        </div>
    </div>
</div>
<div class="row">
    @if ($resolucion)
        <div class="col-8 form-group">
            {!! Form::label('subtipo', 'Subtipo', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('subtipotramite', $subtipos, $resolucion->subtipo_id ? $resolucion->subtipo_id : '', ['class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite', 'onchange' => 'handleChangeSubtipo();']) !!}
            </div>
        </div>
    @else
        <div class="col-8 form-group">
            {!! Form::label('subtipo', 'Subtipo', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('subtipotramite', ['' => '--Elije un subtipo'], null, ['class' => 'form-control form-control-sm  input-xs', 'id' => 'subtipotramite', 'onchange' => 'handleChangeSubtipo();']) !!}
            </div>
        </div>
    @endif
    @if ($resolucion)
        <div class=" form-group col-4">
            {!! Form::label('tramiteref', 'Tramite ref.', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('tramiteref', $tramites, $resolucion->tramiteref_id, ['class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref']) !!}
            </div>
        </div>
    @else
        <div class=" form-group col-4">
            {!! Form::label('tramiteref', 'Tramite ref.', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('tramiteref', ['' => 'Seleccione'], '', ['class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref']) !!}
            </div>
        </div>
    @endif
</div>
<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('numero', 'Número de Resolución*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblnrodocumento']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('numero', null, ['class' => 'form-control  input-xs', 'id' => 'numero']) !!}
        </div>
    </div>
    <div class="col-4 form-group">
        {!! Form::label('ordenpago_id', 'Nro. Orden pago', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::select('ordenpago_id', $cboOrdenpago, null, ['class' => 'form-control  input-xs', 'id' => 'ordenpago_id']) !!}
        </div>
    </div>
    <div class="col-4 form-group">
        {!! Form::label('inspeccion_id', 'Nro. Inspección', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::select('inspeccion_id', $cboInspeccion, null, ['class' => 'form-control  input-xs', 'id' => 'inspeccion_id']) !!}
        </div>
    </div>
</div>
<div class="row d-none" id="divSalubridad">
    <div class="col-4 form-group">
        {!! Form::label('localidad', 'Localidad (Ubr.- PJ)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('localidad', null, ['class' => 'form-control  input-xs', 'id' => 'localidad']) !!}
        </div>
    </div>
    <div class="col-4 form-group">
        {!! Form::label('zona', 'Zona*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('zona', null, ['class' => 'form-control  input-xs', 'id' => 'zona']) !!}
        </div>
    </div>
    <div class="col-4 form-group">
        {!! Form::label('categoria', 'Categoría*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('categoria', null, ['class' => 'form-control  input-xs', 'id' => 'categoria']) !!}
        </div>
    </div>
</div>
<div id="divEdificaciones" class="d-none">
    <div class="form-group">
        {!! Form::label('proyecto', 'Proyecto*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblproyecto']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('proyecto', null, ['class' => 'form-control  input-xs', 'id' => 'proyecto', 'placeholder' => 'Ejm. LICENCIA DE CONSTRUCCION DE OBRA NUEVA VIVIENDA UNIFAMILIAR']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm">
            {!! Form::label('uso', 'Uso*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lbluso']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('uso', null, ['class' => 'form-control  input-xs', 'id' => 'uso', 'placeholder' => 'Ejm. Vivienda']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('zonificacion', 'Zonificación*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblzonificacion']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('zonificacion', null, ['class' => 'form-control  input-xs', 'id' => 'zonificacion', 'placeholder' => 'Ejm. R.D.M']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('altura', 'Altura*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblaltura']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('altura', null, ['class' => 'form-control  input-xs', 'id' => 'altura', 'placeholder' => 'Ejm. 01 Nivel']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        @php
            
        @endphp
        <div class="form-group col-sm">
            {!! Form::label('areapiso1', '1er Piso M2', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblareapiso1']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('areapiso1', null, ['class' => 'form-control  input-xs', 'id' => 'areapiso1', 'step' => '0.01']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('areapiso2', '2do Piso M2', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblareapiso2']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('areapiso2', null, ['class' => 'form-control  input-xs', 'id' => 'areapiso2', 'step' => '0.01']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('areapiso3', '3er Piso M2', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblareapiso3']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('areapiso3', null, ['class' => 'form-control  input-xs', 'id' => 'areapiso3', 'step' => '0.01']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('areapiso4', '4to Piso M2', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblareapiso4']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('areapiso4', null, ['class' => 'form-control  input-xs', 'id' => 'areapiso4', 'step' => '0.01']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('azotea', 'Azotea M2', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblazotea']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('azotea', null, ['class' => 'form-control  input-xs', 'id' => 'azotea', 'step' => '0.01']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="form-group col-sm">
				{!! Form::label('area', 'Área Construida(m2)*', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id'=>'lblarea')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::number('area', null, array('class' => 'form-control  input-xs', 'id' => 'area', 'step'=>'0.01')) !!}
				</div>
			</div> --}}
        <div class="form-group col-sm">
            {!! Form::label('valor', 'Valor de la Obra(S/.)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblvalor']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('valor', null, ['class' => 'form-control  input-xs', 'id' => 'valor', 'step' => '0.01']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('responsableobra', 'Responsable de la Obra*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblresponsableobra']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('responsableobra', null, ['class' => 'form-control  input-xs', 'id' => 'responsableobra']) !!}
            </div>
        </div>
    </div>
</div>
<div class="d-none" id="divLicenciasAutorizaciones">
    <div class="d-none" id="divAnuncios">
        <div class="row">
            <div class="form-group col-sm">
                {!! Form::label('claseanuncio', 'Clase*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblclaseanuncio']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::text('claseanuncio', null, ['class' => 'form-control  input-xs', 'id' => 'claseanuncio', 'placeholder' => 'Ej. LUMINOSO']) !!}
                </div>
            </div>
            <div class="form-group col-sm">
                {!! Form::label('ubicacionanuncio', 'Ubicación*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblubicacionanuncio']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::text('ubicacionanuncio', null, ['class' => 'form-control  input-xs', 'id' => 'ubicacionanuncio', 'placeholder' => 'Ej. EN FACHADA']) !!}
                </div>
            </div>
            <div class="form-group col-sm">
                {!! Form::label('vigencia', 'Vigencia (Años)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblvigencia']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::text('vigencia', null, ['class' => 'form-control  input-xs', 'id' => 'vigencia', 'placeholder' => 'Ej. 02']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('leyenda', 'Leyenda del Anuncio*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblleyenda']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('leyenda', null, ['class' => 'form-control  input-xs', 'id' => 'leyenda', 'placeholder' => '']) !!}
            </div>
        </div>
    </div>
    <div class="row" id="divLicenciasFuncionamiento">
        <div class="form-group col-sm">
            {!! Form::label('nombrecomercial', 'Nombre Comercial*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblnombrecomercial']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('nombrecomercial', null, ['class' => 'form-control  input-xs', 'id' => 'nombrecomercial']) !!}
            </div>
        </div>
        @if ($resolucion)
            <div class="form-group col-sm">
                {!! Form::label('funcionamiento', 'Tipo de Funcionamiento*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('funcionamiento', 'TEMPORAL', $resolucion->funcionamiento == 'TEMPORAL' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="Temporal">Temporal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('funcionamiento', 'DEFINITIVO', $resolucion->funcionamiento == 'DEFINITIVO' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="Definitivo">Definitivo</label>
                    </div>
                </div>
            </div>
        @else
            <div class="form-group col-sm">
                {!! Form::label('funcionamiento', 'Tipo de Funcionamiento*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('funcionamiento', 'TEMPORAL', true, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="Temporal">Temporal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('funcionamiento', 'DEFINITIVO', false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="Definitivo">Definitivo</label>
                    </div>
                </div>
            </div>
        @endif
        @if ($resolucion)
            <div class="col-sm form-group">
                {!! Form::label('viapublica', 'Uso de Vía Pública*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('viapublica', 'SI', $resolucion->viapublica == 'SI' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="Si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('viapublica', 'NO', $resolucion->viapublica == 'NO' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="No">No</label>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm form-group">
                {!! Form::label('viapublica', 'Uso de Vía Pública*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('viapublica', 'Si', false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="Si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('viapublica', 'No', true, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="No">No</label>
                    </div>
                </div>
            </div>
        @endif
        @if ($resolucion)
            <div class="col-sm form-group">
                {!! Form::label('tipopersona', 'Tipo de persona*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
                <div class="row  form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipopersona', 'P/NAT', $resolucion->tipopersona == 'P/NAT' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="P/NAT">P/NAT</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipopersona', 'JUR', $resolucion->tipopersona == 'JUR' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="JUR">JUR</label>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm form-group">
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
		<div class="col-sm form-group">
			{!! Form::label('duplicado', 'Duplicado', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
			<div class="row  form-group ml-2">
				<div class="form-check form-check-inline">
					{{ Form::radio('duplicado', 'SI', false, ['class' => 'form-check-input']) }}
					<label class="form-check-label" for="SI">SI</label>
				</div>
				<div class="form-check form-check-inline">
					{{ Form::radio('duplicado', 'NO', false, ['class' => 'form-check-input']) }}
					<label class="form-check-label" for="NO">NO</label>
				</div>
			</div>
		</div>

    </div>
    <div class="row">
        <div class="col-sm form-group" id="certificadoGroup">
            {!! Form::label('nrocertificado', 'Certificado Nro*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblnrocertificado']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('nrocertificado', null, ['class' => 'form-control  input-xs', 'id' => 'nrocertificado']) !!}
            </div>
        </div>
        <div class="form-group col-sm d-none" id="divNombreComercial">
            {!! Form::label('nombrecomercial2', 'Nombre Comercial*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblnombrecomercial2']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('nombrecomercial2', $resolucion ? $resolucion->nombrecomercial : null, ['class' => 'form-control  input-xs', 'id' => 'nombrecomercial2']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('arearesolucion', 'Área (m2)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblarea']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::number('arearesolucion', $resolucion ? $resolucion->area : null, ['class' => 'form-control  input-xs', 'id' => 'arearesolucion', 'step' => '0.01']) !!}
            </div>
        </div>
    </div>
    <p class=" font-weight-bold">Para Bodegas</p>
    <hr>
    <div class="row">
        <div class="form-group col-sm">
            {!! Form::label('desdehora', 'Hora Atención (Desde)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lbldesdehora']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('desdehora', $resolucion ? $resolucion->desdehora : null, ['class' => 'form-control  input-xs', 'id' => 'desdehora', 'placeholder' => 'Ejm. (Formato 24 hrs.) : 9']) !!}
            </div>
        </div>
        <div class="form-group col-sm">
            {!! Form::label('hastahora', 'Hora Atención (Hasta)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblhastahora']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('hastahora', $resolucion ? $resolucion->hastahora : null, ['class' => 'form-control  input-xs', 'id' => 'hastahora', 'placeholder' => 'Ejm. (Formato 24 hrs.) : 18']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm form-group">
        {!! Form::label('dni', 'DNI', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('dni', null, ['class' => 'form-control  input-xs', 'id' => 'dni']) !!}
        </div>
    </div>
    <div class="col-sm form-group">
        {!! Form::label('ruc', 'RUC', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12 input-group pl-0">
            <div class="col-lg-10 col-md-10 col-sm-10">
                {!! Form::text('ruc', null, ['class' => 'form-control  input-xs', 'id' => 'ruc']) !!}
            </div>
            <div class="col-lg-1 col-sm-1 col-md-1 pl-1">
                {!! Form::button('<i class="fa fa-search "></i>', ['class' => 'btn btn-primary', 'title' => 'Buscar RUC', 'id' => 'botonBuscarRuc']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('contribuyente', 'Contribuyente*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblcontribuyente']) !!}
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::text('contribuyente', null, ['class' => 'form-control  input-xs', 'id' => 'contribuyente']) !!}
    </div>
</div>
<div class="row" id="inforuc">
    <div class="form-group col-sm">
        {!! Form::label('razonsocial', 'Razon Social*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('razonsocial', null, ['class' => 'form-control  input-xs', 'id' => 'razonsocial']) !!}
        </div>
    </div>
    <div class="form-group col-sm">
        {!! Form::label('girocomercial', 'Giro Comercial*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('girocomercial', null, ['class' => 'form-control  input-xs', 'id' => 'girocomercial']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('direccion', 'Dirección Completa*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lbldireccion']) !!}
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::text('direccion', null, ['class' => 'form-control  input-xs', 'id' => 'direccion']) !!}
    </div>
</div>
<div class="row">
    @php
        $verificar = false;
        if ($resolucion) {
            $direccion = explode('-', $resolucion->direccion);
            if (count($direccion) >= 3) {
                $verificar = true;
            } else {
                $verificar = false;
            }
        }
    @endphp
    <div class="form-group col-sm">
        {!! Form::label('jurisdicion', 'Calle o Avenida*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lbljurisdicion']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('jurisdicion', $verificar ? explode('-', $resolucion->direccion)[0] : null, ['class' => 'form-control  input-xs', 'id' => 'jurisdicion', 'placeholder' => 'Ej. Calle Proceres']) !!}
        </div>
    </div>
    <div class="form-group col-sm">
        {!! Form::label('numerocalle', 'Número*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblnumerocalle']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('numerocalle', $verificar ? (int) explode('-', $resolucion->direccion)[1] : null, ['class' => 'form-control  input-xs', 'id' => 'numerocalle', 'placeholder' => 'Ej. 154']) !!}
        </div>
    </div>
    <div class="form-group col-sm">
        {!! Form::label('urbanizacion22', 'Urbanización*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblurbanizacion22']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::text('urbanizacion22', $verificar ? explode('-', $resolucion->direccion)[2] : null, ['class' => 'form-control  input-xs', 'id' => 'urbanizacion22', 'placeholder' => 'Ej. Urb. Latina']) !!}
        </div>
    </div>
</div>

<div id="divDefensaCivil" class="row d-none">
    <div class="form-group col-sm">
        {!! Form::label('capacidadmaxima', 'Capacidad Máxima (Personas)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblcapacidadmaxima']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('capacidadmaxima', $resolucion ? $resolucion->area : null, ['class' => 'form-control  input-xs', 'id' => 'capacidadmaxima']) !!}
        </div>
    </div>
    <div class="form-group col-sm">
        {!! Form::label('areadefensa', 'Area (M2)*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label', 'id' => 'lblareadefensa']) !!}
        <div class="col-lg-12 col-md-12 col-sm-12">
            {!! Form::number('areadefensa', $resolucion ? $resolucion->area : null, ['class' => 'form-control  input-xs', 'id' => 'areadefensa', 'placeholder' => 'Ej. 100']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('observacion', 'Observacion*', ['class' => 'col-lg-12 col-md-12 col-sm-12 control-label']) !!}
    <div class="col-lg-12 col-md-12 col-sm-12">
        {!! Form::textarea('observacion', $resolucion->observaciones ?? null, ['class' => 'form-control  input-xs', 'id' => 'observacion', 'rows' => 2, 'style' => 'resize:none;']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
        {!! Form::button('<i class="fa fa-check fa-lg"></i> ' . $boton, ['class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\'' . $entidad . '\', this)']) !!}
        {!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', ['class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar' . $entidad, 'onclick' => 'cerrarModal();']) !!}
    </div>
</div>
{!! Form::close() !!}
<style>
    .select2-container--default .select2-selection--single {
        height: fit-content !important;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
        //ordenpagoSelect2();
        //inspeccionSelect2();
        configurarAnchoModal('1000');
        tramitesSelect2();
        init(IDFORMMANTENIMIENTO + '{!! $entidad !!}', 'M', '{!! $entidad !!}');
        $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').inputmask("99999999999");
        $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="dni"]').inputmask("99999999");
        var tipotogle = $('#toggletipo').val();
        showTipo(tipotogle);


        $('#botonBuscarRuc').on('click', function() {
            buscarRUC();
        });

        $("input[name=funcionamiento]").change(function() {
            var valor = $(this).val();
            if (valor === 'TEMPORAL') {
                $('#divFechaVencimiento').removeClass('d-none');
                console.log('111');

            } else if (valor == 'DEFINITIVO') {
                $('#divFechaVencimiento').addClass('d-none');
                console.log('22');

            }
        });

        $('#ordenpago_id').on('change', function() {
            var value = $(this).val();
            $.ajax({
                type: 'POST',
                url: "{{ route('inspeccion.getInfo') }}",
                data: "_token=" + $(IDFORMMANTENIMIENTO +
                        '{!! $entidad !!} :input[name="_token"]').val() +
                    "&ordenpago_id=" + value,
                success: function(a) {
                    $(IDFORMMANTENIMIENTO +
                        '{!! $entidad !!} :input[name="direccion"]').val(a
                        .direccion);
                    $(IDFORMMANTENIMIENTO +
                        '{!! $entidad !!} :input[name="contribuyente"]').val(a
                        .representante);
                    $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="dni"]')
                        .val(a.dni_ruc);
                    $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="ruc"]')
                        .val(a.dni_ruc);
                    console.log(a.direccion);
                    console.log(a);
                }

            });
        });

		
        function buscarRUC() {
            var reg = new RegExp('^[0-9]+$');
            if ($(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val() == "") {
                toastr.warning("Debe ingresar un RUC.", 'Error:');
            } else if (!reg.test($(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]').val())) {
                toastr.warning("El RUC ingresado es incorrecto.", 'Error:');
            } else {
                $.ajax({
                    type: "POST",
                    url: "empresacourier/buscarRUC",
                    data: "ruc=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="ruc"]')
                        .val() + "&_token=" + $(IDFORMMANTENIMIENTO +
                            '{!! $entidad !!} :input[name="_token"]').val(),
                    beforeSend() {
                        alert("Consultando...");
                    },
                    success: function(a) {
                        datos = JSON.parse(a);
                        if (datos.length == 0) {
                            toastr.warning("El RUC ingresado es incorrecto.", 'Error:');
                        } else {
                            $("#razonsocial").val(datos.RazonSocial);
                            $("#direccion").val(datos.Direccion);
                        }
                    }
                });
            }
        }

    });

    function handleChangeSubtipo() {
        var subtipo = $('#subtipotramite').val();
        var tipo = $('#tipo_id').val();
        if (tipo == '1') {
            if (subtipo == '1' || subtipo == '3') {
                $('#certificadoGroup').removeClass('d-none');
                $('#lblnrodocumento').text('Nro. de Resolución');
                $('#divAnuncios').addClass('d-none');
                $('#divLicenciasFuncionamiento').removeClass('d-none');
                $('#divNombreComercial').addClass('d-none');
                if (subtipo == '1') {
                    generarNumero2(subtipo, tipo);
                    generarNumero3(subtipo, tipo);
                } else {
                    generarNumero3(subtipo, tipo);
                    generarNumero4(subtipo, tipo);
                }

            } else if (subtipo == '2') {
                if (subtipo == '2') {
                    $('#divAnuncios').removeClass('d-none');
                    $('#divLicenciasFuncionamiento').addClass('d-none');
                    $('#divNombreComercial').addClass('d-none');
                }
                generarNumero3(subtipo, tipo);
                $('#certificadoGroup').addClass('d-none');
                $('#lblnrodocumento').text('Nro. de Autorización');
            }
        }
    }

    function showTipo(tipo) {
        switch (tipo) {
            case "1":
                $('#divSalubridad').addClass('d-none');
                $('#divEdificaciones').addClass('d-none');
                $('#inforuc').removeClass('d-none');
                $('#divLicenciasAutorizaciones').removeClass('d-none');
                $('#lblcontribuyente').text('Contribuyente*');
                $('#lbldireccion').text('Dirección Completa*');
                $('#lblnrodocumento').text('Nro. de Resolucion');
                $('#divDefensaCivil').addClass('d-none');


                break;
            case "2":
                $('#divSalubridad').addClass('d-none');
                $('#divEdificaciones').removeClass('d-none');
                $('#lblcontribuyente').text('Propietario*');
                $('#lbldireccion').text('Ubicación*');
                $('#inforuc').addClass('d-none');
                $('#divLicenciasAutorizaciones').addClass('d-none');
                $('#lblnrodocumento').text('Nro. de Resolución');
                $('#divDefensaCivil').addClass('d-none');


                break;
            case "3":
                $('#divSalubridad').removeClass('d-none');
                $('#divEdificaciones').addClass('d-none');
                $('#inforuc').removeClass('d-none');
                $('#lblcontribuyente').text('Contribuyente*');
                $('#lbldireccion').text('Dirección*');
                $('#divLicenciasAutorizaciones').addClass('d-none');
                $('#lblnrodocumento').text('Nro. de Certificado');
                $('#divDefensaCivil').addClass('d-none');


                break;
            case "4":
                $('#divSalubridad').addClass('d-none');
                $('#divDefensaCivil').removeClass('d-none');
                $('#divEdificaciones').addClass('d-none');
                $('#inforuc').removeClass('d-none');
                $('#lblcontribuyente').text('Contribuyente*');
                $('#lbldireccion').text('Dirección*');
                $('#divLicenciasAutorizaciones').addClass('d-none');
                $('#lblnrodocumento').text('Nro. de Resolución');

                break;
            default:
                $('#lblcontribuyente').text('Contribuyente*');
                $('#lbldireccion').text('Dirección*');
                $('#divLicenciasAutorizaciones').addClass('d-none');
                $('#lblnrodocumento').text('Nro. de Resolución');
                $('#divDefensaCivil').addClass('d-none');


                break;
        }
        ordenpagoSelect2(tipo);
        inspeccionSelect2(tipo);
    }

    function inspeccionSelect2(tipo) {
        $('#inspeccion_id').select2({
            ajax: {
                delay: 250,
                url: '{{ route('resolucion.listarInspeccion') }}',
                data: function(params) {
                    var query = {
                        search: params.term,
                        tipo: tipo,
                    }
                    return query;
                },
                placeholder: 'Nro. de Inspección',
                minimumInputLength: 1,
                processResults: function(res) {
                    var datos = JSON.parse(res);
                    return {
                        results: datos.results
                    };
                }
            }
        });
    }

    function ordenpagoSelect2(tipo) {
        $('#ordenpago_id').select2({
            ajax: {
                delay: 250,
                url: '{{ route('resolucion.listarOrdenpago') }}',
                data: function(params) {
                    var query = {
                        search: params.term,
                        tipo: tipo,
                    }
                    return query;
                },
                placeholder: 'Nro. de Orden Pago',
                minimumInputLength: 1,
                processResults: function(res) {
                    var datos = JSON.parse(res);
                    return {
                        results: datos.results
                    };
                }
            }
        });
    }

    function generarNumero() {
        var tipo = $('#tipo_id').val();
        showTipo(tipo);
        $.ajax({
            type: "POST",
            url: "{{ route('resolucion.generarnumero') }}",
            data: "_token=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +
                "&tipo=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="tipo"]').val(),
            success: function(a) {
                $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
            }
        });
    }


    function generarNumero2(value, tipo) {
        var subtipo = value;
        showTipo(tipo);
        $.ajax({
            type: "POST",
            url: "{{ route('resolucion.generarnumero2') }}",
            data: "_token=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +
                "&subtipotramite=" + $(IDFORMMANTENIMIENTO +
                    '{!! $entidad !!} :input[name="subtipotramite"]').val(),
            success: function(a) {
                $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="nrocertificado"]').val(a);
            }
        });
    }

    function generarNumero3(value, tipo) {
        var subtipo = value;
        showTipo(tipo);
        $.ajax({
            type: "POST",
            url: "{{ route('resolucion.generarnumero2') }}",
            data: "_token=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +
                "&subtipotramite=" + $(IDFORMMANTENIMIENTO +
                    '{!! $entidad !!} :input[name="subtipotramite"]').val(),
            success: function(a) {
                $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="numero"]').val(a);
            }
        });
    }

    function generarNumero4(value, tipo) {
        var subtipo = value;
        showTipo(tipo);
        $.ajax({
            type: "POST",
            url: "{{ route('resolucion.generarnumero3') }}",
            data: "_token=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val() +
                "&subtipotramite=" + $(IDFORMMANTENIMIENTO +
                    '{!! $entidad !!} :input[name="subtipotramite"]').val(),
            success: function(a) {
                $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="nrocertificado"]').val(a);
            }
        });
    }

    function cambiarsubtipos() {
        var tipo_id = $('#tipo_id').val();
        if (tipo_id.length > 0) {
            $.ajax({
                url: "{{ route('ordenpago.listarsubtipos') }}",
                type: 'GET',
                data: {
                    tipo_id
                },
                dataType: 'json',
                success: function(response) {
                    var areaselect = $('#subtipotramite');
                    areaselect.empty();
                    areaselect.append('<option value="">--Elije un subtipo</option>')
                    $.each(response.data, function(key, value) {
                        areaselect.append("<option value='" + value.id + "'>" + value.descripcion +
                            "</option>");
                    });
                },
                error: function() {
                    alert('Hubo un error obteniendo las areas!');
                }
            });
        }
    }

    function tramitesSelect2() {
        $('#tramiteref').select2({
            ajax: {
                delay: 250,
                url: '{{ route('tramite.listartramites') }}',
                placeholder: 'Indique el trámite de referencia',
                minimumInputLength: 1,
                processResults: function(data) {
                    var datos = JSON.parse(data);
                    return {
                        results: datos.results
                    };
                }
            }
        });
    }
	function funBaja() {
			var idformulario = IDFORMMANTENIMIENTO + '{{ $entidad }}';
			var entidad = "{{$entidad}}";
            var respuesta = '';
            var listar = 'NO';
            if ($(idformulario + ' :input[id = "listar"]').length) {
                var listar = $(idformulario + ' :input[id = "listar"]').val();
            };

			$.ajax({
				type: "POST",
				url: "{{route('resolucion.baja')}}",
                data: "id="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="bajaid"]').val()+"&_token="+$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
				success: function(msg) {
					respuesta = msg;
					if (respuesta.trim() === 'OK') {
                        cerrarModal();
                        Hotel.notificaciones("Accion realizada correctamente", "Realizado", "success");
                        if (listar.trim() === 'SI') {
                            buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
                        }
                    } else {
                        mostrarErrores(respuesta, idformulario, entidad);
                    }
				},
				error: function(e){
					respuesta='ERROR';
				}
			});
            

        }

</script>