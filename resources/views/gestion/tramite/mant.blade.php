<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($tramite, $formData) !!}
{!! Form::hidden('listar', $listar, ['id' => 'listar']) !!}
{!! Form::hidden('pretramite_id', $tipo == 'VIRTUAL' ? $tramite->id : '', ['id' => 'pretramite_id']) !!}
<div class="row">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label>Tipo de tramite *</label>
                <div class="row form-group ml-2">
                    @if ($mesapartes == 1)
                        <div class="form-check form-check-inline">
                            {{ Form::radio('tipotramite', 'tupa', true, ['class' => 'form-check-input']) }}
                            <label class="form-check-label" for="tupa">Tupa</label>
                        </div>
                    @endif
                    <div class="form-check form-check-inline">
                        {{ Form::radio('tipotramite', 'interno', true, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="interno">Interno</label>
                    </div>
                    {{-- <div class="form-check form-check-inline">
						{{Form::radio('tipotramite', 'externo', false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="externo">Externo</label>
					</div>
					<div class="form-check form-check-inline">
						{{Form::radio('tipotramite', 'courier', false , array("class"=>"form-check-input"))}}
						<label class="form-check-label" for="courier">Courier</label>
					</div> --}}
                </div>
            </div>
            <div class="col-6">
                <label>Forma de recepción *</label>
                <div class="row form-group ml-2">
                    <div class="form-check form-check-inline">
                        {{ Form::radio('formarecepcion', 'manual', $tipo == 'VIRTUAL' ? false : true, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="manual">Manual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio('formarecepcion', 'digital', $tipo == 'VIRTUAL' ? true : false, ['class' => 'form-check-input']) }}
                        <label class="form-check-label" for="digital">Digital</label>
                    </div>
                    <div id="divFiles" class="form-group mt-2 d-none">
                        {{ Form::file('ficheros[]', ['multiple' => true, 'class' => 'form-control']) }}
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col form-group">
                {!! Form::label('tipodocumento', 'Tipo documento *', ['class' => 'control-label']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::select('tipodocumento', $tipodocumentos, '', ['class' => 'form-control form-control-sm input-xs', 'id' => 'tipodocumento']) !!}
                </div>
            </div>
            <div class="col form-group">
                {!! Form::label('numero', 'Número de Documento*', ['class' => 'control-label']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::text('numero', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'numero']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9 form-group">
                {!! Form::label('asunto', 'Asunto *', ['class' => 'control-label']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::text('asunto', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'asunto']) !!}
                </div>
            </div>
            <div class="col-3 form-group">
                {!! Form::label('folios', 'Folios *', ['class' => 'control-label']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::number('folios', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'folios']) !!}
                </div>
            </div>
        </div>
        @if ($tipo == 'VIRTUAL' || $mesapartes == 1)
            <div class=" form-group " id="divremitente">
                {!! Form::label('remitente', 'Remitente *', ['class' => 'control-label']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::text('remitente', null, ['class' => 'form-control form-control-sm input-xs typeahead ', 'id' => 'remitente', 'data-provide' => 'typeahead', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        @else
            <div class=" form-group " id="divremitente">
                {!! Form::label('remitente', 'Remitente *', ['class' => 'control-label']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::select('remitente', ['' => 'Indique el remitente'], '', ['class' => 'form-control form-control-sm input-xs ', 'id' => 'remitente2']) !!}
                </div>
            </div>
        @endif

        <div class=" form-group " id="divCorreo">
            {!! Form::label('correo', 'Correo', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::text('correo', null, ['class' => 'form-control form-control-sm input-xs ', 'id' => 'correo']) !!}
            </div>
        </div>
        <div class=" form-group" id="divprocedimiento">
            {!! Form::label('procedimiento', 'Procedimiento *', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('procedimiento', ['' => 'Indique el procedimiento'], '', ['class' => 'form-control form-control-sm input-xs', 'id' => 'procedimiento']) !!}
            </div>
        </div>
        <div class="form-group d-none" id="divareadestino">
            {!! Form::label('areadestino', 'Area destino *', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('areadestino', ['' => 'Indique el area destino'], '', ['class' => 'form-control form-control-sm input-xs', 'id' => 'areadestino']) !!}
            </div>
        </div>

    </div>
    <div class="col-6">
        <div class=" form-group">
            {!! Form::label('tramiteref', 'Tramite ref.', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::select('tramiteref', ['' => 'Seleccione'], '', ['class' => 'form-control form-control-sm input-xs', 'id' => 'tramiteref']) !!}
            </div>
        </div>
        {{-- <div class=" form-group">
			{!! Form::label('archivador', 'Archivador', array('class' => 'control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				{!! Form::select('archivador', [""=>"Seleccione"] , "",array('class' => 'form-control form-control-sm input-xs', 'id' => 'archivador')) !!}
			</div>
		</div> --}}
        <label>Prioridad </label>
        <div class="row  form-group ml-2">
            <div class="form-check form-check-inline">
                {{ Form::radio('prioridad', 'alta', false, ['class' => 'form-check-input']) }}
                <label class="form-check-label" for="alta">Alta</label>
            </div>
            <div class="form-check form-check-inline">
                {{ Form::radio('prioridad', 'normal', true, ['class' => 'form-check-input']) }}
                <label class="form-check-label" for="normal">Normal</label>
            </div>
            <div class="form-check form-check-inline">
                {{ Form::radio('prioridad', 'baja', false, ['class' => 'form-check-input']) }}
                <label class="form-check-label" for="baja">Baja</label>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('observacion', 'Observación ', ['class' => 'control-label']) !!}
            <div class="col-lg-12 col-md-12 col-sm-12">
                {!! Form::textarea('observacion', null, ['class' => 'form-control form-control-sm input-xs', 'id' => 'observacion', 'rows' => 5, 'style' => 'resize:none;']) !!}
            </div>
        </div>
    </div>
</div>

{{-- FIN DATOS DEL EXPEDIENTE --}}


<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
        {!! Form::button('<i class="fa fa-check fa-lg"></i> ' . $boton, ['class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'type' => 'submit']) !!}
        {{-- {!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!} --}}
        {!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', ['class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar' . $entidad, 'onclick' => 'cerrarModal();']) !!}
    </div>
</div>
<style>
    .typeahead {
        z-index: 1051;
    }

    .modal-body {
        overflow-y: inherit;
    }

</style>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('1000');
        init(IDFORMMANTENIMIENTO + '{!! $entidad !!}', 'M', '{!! $entidad !!}');

        // $('.typeahead').typeahead({
        // 	source: [
        // 		{id: "someId1", name: "Display name 1"},
        // 		{id: "someId2", name: "Display name 2"}
        // 	],
        // 	autoSelect: false
        // });
        var valuetipo = $('input[name=tipotramite]:checked').val();
        generarNumero();
        tramitesSelect2();
        procedimientoSelect2();
        archivadoresSelect2();
        areadestinoSelect2();
        remitenteSelect2();
        toggletramite(valuetipo);

        $.get('{{ route('tramite.listarpersonal') }}', function(data) {
            $("#remitente").typeahead({
                source: data
            });
        }, 'json');


        $("input[name=tipotramite]").change(function() {
            var valor = $(this).val();
            toggletramite(valor);
            // var valor = $(this).val(); 
            // if(valor == 'tupa' || valor == 'interno' || valor == 'externo'){
            // 	$('#divremitente').removeClass('d-none');
            // 	$('#divdestino').addClass('d-none');

            // }else if (valor == 'courier'){
            // 	$('#divremitente').addClass('d-none');
            // 	$('#divdestino').removeClass('d-none');
            // 	destinoSelect2();
            // }

            // if(valor == 'tupa'){
            // 	$('#divprocedimiento').removeClass('d-none');
            // 	$('#divareadestino').addClass('d-none');
            // }else {
            // 	$('#divprocedimiento').addClass('d-none');
            // 	$('#divareadestino').removeClass('d-none');
            // 	areadestinoSelect2();
            // }
        });
        $("input[name=formarecepcion]").change(function() {
            var valor = $(this).val();

            // if(valor == 'tupa' || valor == 'interno' || valor == 'externo'){
            // 	$('#divremitente').removeClass('d-none');
            // 	$('#divdestino').addClass('d-none');

            // }else if (valor == 'courier'){
            // 	$('#divremitente').addClass('d-none');
            // 	$('#divdestino').removeClass('d-none');
            // 	destinoSelect2();
            // }

            if (valor == 'digital') {
                $('#divFiles').removeClass('d-none');
            } else {
                $('#divFiles').addClass('d-none');
            }
        });


    });

    function toggletramite(valor) {
        if (valor == 'tupa' || valor == 'interno' || valor == 'externo') {
            $('#divremitente').removeClass('d-none');
            $('#divdestino').addClass('d-none');

        } else if (valor == 'courier') {
            $('#divremitente').addClass('d-none');
            $('#divdestino').removeClass('d-none');
            destinoSelect2();
        }

        if (valor == 'tupa') {
            $('#divprocedimiento').removeClass('d-none');
            $('#divareadestino').addClass('d-none');
            $('#divCorreo').removeClass('d-none');
        } else {
            $('#divprocedimiento').addClass('d-none');
            $('#divareadestino').removeClass('d-none');
            $('#divCorreo').addClass('d-none');
            areadestinoSelect2();
        }
    }

    function destinoSelect2() {
        $('#destino').select2({
            ajax: {
                delay: 250,
                url: '{{ route('tramite.listarempresascourier') }}',
                placeholder: 'Indique el destino',
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

    function areadestinoSelect2() {
        $('#areadestino').select2({
            ajax: {
                delay: 250,
                url: '{{ route('tramite.listarareas') }}',
                placeholder: 'Indique el area destino',
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

    function procedimientoSelect2() {
        $('#procedimiento').select2({
            ajax: {
                delay: 250,
                url: '{{ route('tramite.listarprocedimientos') }}',
                placeholder: 'Indique el procedimiento',
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

    function archivadoresSelect2() {
        $('#archivador').select2({
            ajax: {
                delay: 250,
                url: '{{ route('tramite.listararchivadores') }}',
                placeholder: 'Indique el archivador',
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

    function remitenteSelect2() {
        $('#remitente2').select2({
            ajax: {
                delay: 250,
                url: '{{ route('tramite.listarremitentes') }}',
                placeholder: 'Indique el remitente',
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

    function generarNumero() {
        $.ajax({
            type: "POST",
            url: "{{ route('tramite.generarnumero') }}",
            data: "_token=" + $(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[name="_token"]').val(),
            success: function(a) {
                console.log(a);
            }
        });
        $(IDFORMMANTENIMIENTO + '{{ $entidad }}').submit(function(event) {
            event.preventDefault();
            var idformulario = IDFORMMANTENIMIENTO + '{{ $entidad }}';
            var entidad = "{{ $entidad }}";
            var formData = new FormData($(this)[0]);
            var respuesta = '';
            var listar = 'NO';
            if ($(idformulario + ' :input[id = "listar"]').length) {
                var listar = $(idformulario + ' :input[id = "listar"]').val();
            };
            var request = $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
            });
            request.done(function(msg) {
                respuesta = msg;
                console.log('eeeee');
            }).fail(function(jqXHR, textStatus) {
                respuesta = 'ERROR';
            }).always(function() {
                if (respuesta.trim() === 'ERROR') {} else {
                    if (respuesta.trim() === 'OK') {
                        cerrarModal();
                        Hotel.notificaciones("Accion realizada correctamente", "Realizado", "success");
                        if (listar.trim() === 'SI') {
                            if (typeof entidad2 != 'undefined' && entidad2 !== '') {
                                entidad = entidad2;
                            }
                            buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
                        }
                    } else if (respuesta.includes('id=?')) {
                        var id = respuesta.trim();
                        var matches = id.match(/(\d+)/);
                        id = matches[0];
                        console.log(id);
                        cerrarModal();
                        Hotel.notificaciones("Accion realizada correctamente", "Realizado", "success");
                        if (listar.trim() === 'SI') {
                            if (typeof entidad2 != 'undefined' && entidad2 !== '') {
                                entidad = entidad2;
                            }
                            buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
                        }
                        window.open("tramite/ticket/pdf/?ticket=" + id, "_blank")
                    } else {
                        mostrarErrores(respuesta, idformulario, entidad);
                    }
                }
            });
        });
    }
</script>
