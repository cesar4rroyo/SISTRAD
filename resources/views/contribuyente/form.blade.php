<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MDJLO</title>

        <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fontawesome-free/css/all.min.css")}}">
    

        <!-- Styles -->
        <style>
             body {
                background-color: #fff;
                color: #131313;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

        </style>
    </head>
    <body>
        <body>
            <div class="card m-4 ">
                <div class="card-header " style="background:#2980b9; color:white;"> 
                    <h3 class="card-title">REGISTRO DE TRÁMITE VIRTUAL</h3>
                </div>
                <div id="divMensajeError"></div>
                <div class="alert alert-success d-none" id='divsuccess' role="alert">
                  <br>
                  <h5>
                  ¡Tu trámite ha sido registrado con éxito! , apenas sea revisado te enviaremos información al correo que proporcionaste.
                  </h5>
                  <br>
                  <div class="text-center py-5">
                  <svg id="b76bd6b3-ad77-41ff-b778-1d1d054fe577" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="470" height="411.67482" viewBox="0 0 570 511.67482"><path d="M879.99927,389.83741a.99678.99678,0,0,1-.5708-.1792L602.86963,197.05469a5.01548,5.01548,0,0,0-5.72852.00977L322.57434,389.65626a1.00019,1.00019,0,0,1-1.14868-1.6377l274.567-192.5918a7.02216,7.02216,0,0,1,8.02-.01318l276.55883,192.603a1.00019,1.00019,0,0,1-.57226,1.8208Z" transform="translate(-315 -194.16259)" fill="#3f3d56"/><polygon points="23.264 202.502 285.276 8.319 549.276 216.319 298.776 364.819 162.776 333.819 23.264 202.502" fill="#e6e6e6"/><path d="M489.25553,650.70367H359.81522a6.04737,6.04737,0,1,1,0-12.09473H489.25553a6.04737,6.04737,0,1,1,0,12.09473Z" transform="translate(-315 -194.16259)" fill="#00bfa6"/><path d="M406.25553,624.70367H359.81522a6.04737,6.04737,0,1,1,0-12.09473h46.44031a6.04737,6.04737,0,1,1,0,12.09473Z" transform="translate(-315 -194.16259)" fill="#00bfa6"/><path d="M603.96016,504.82207a7.56366,7.56366,0,0,1-2.86914-.562L439.5002,437.21123v-209.874a7.00817,7.00817,0,0,1,7-7h310a7.00818,7.00818,0,0,1,7,7v210.0205l-.30371.12989L606.91622,504.22734A7.61624,7.61624,0,0,1,603.96016,504.82207Z" transform="translate(-315 -194.16259)" fill="#fff"/><path d="M603.96016,505.32158a8.07177,8.07177,0,0,1-3.05957-.59863L439.0002,437.54521v-210.208a7.50851,7.50851,0,0,1,7.5-7.5h310a7.50851,7.50851,0,0,1,7.5,7.5V437.68779l-156.8877,66.999A8.10957,8.10957,0,0,1,603.96016,505.32158Zm-162.96-69.1123,160.66309,66.66455a6.1182,6.1182,0,0,0,4.668-.02784l155.669-66.47851V227.33721a5.50653,5.50653,0,0,0-5.5-5.5h-310a5.50653,5.50653,0,0,0-5.5,5.5Z" transform="translate(-315 -194.16259)" fill="#3f3d56"/><path d="M878,387.83741h-.2002L763,436.85743l-157.06982,67.07a5.06614,5.06614,0,0,1-3.88038.02L440,436.71741l-117.62012-48.8-.17968-.08H322a7.00778,7.00778,0,0,0-7,7v304a7.00779,7.00779,0,0,0,7,7H878a7.00779,7.00779,0,0,0,7-7v-304A7.00778,7.00778,0,0,0,878,387.83741Zm5,311a5.002,5.002,0,0,1-5,5H322a5.002,5.002,0,0,1-5-5v-304a5.01106,5.01106,0,0,1,4.81006-5L440,438.87739l161.28027,66.92a7.12081,7.12081,0,0,0,5.43994-.03L763,439.02741l115.2002-49.19a5.01621,5.01621,0,0,1,4.7998,5Z" transform="translate(-315 -194.16259)" fill="#3f3d56"/><path d="M602.345,445.30958a27.49862,27.49862,0,0,1-16.5459-5.4961l-.2959-.22217-62.311-47.70752a27.68337,27.68337,0,1,1,33.67407-43.94921l40.36035,30.94775,95.37793-124.38672a27.68235,27.68235,0,0,1,38.81323-5.12353l-.593.80517.6084-.79346a27.71447,27.71447,0,0,1,5.12353,38.81348L624.36938,434.50586A27.69447,27.69447,0,0,1,602.345,445.30958Z" transform="translate(-315 -194.16259)" fill="#00bfa6"/></svg>

                  </div>
                </div>
                <form class="m-4" id="pretramite-form">
                 <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                 <input type="hidden" name="listArchivos" id="listArchivos" >
                 
                 <!-- DATOS DEL ESTUDIANTE-->
                 <blockquote class="m-2 " >
                   <p  style="color: rgb(25, 64, 205); font-style:italic;">*Ingresa tu DNI y pulsa en buscar, si tus datos no se cargan, ingrésalos manualmente.</p>
                 </blockquote>
                 <h5>Datos del trámite</h5>
                 <div class="form-row ">
                   <div class=" my-2 col-xs-12 col-md-6 input-group">
                     <input type="text" class="form-control"  placeholder="DNI" name="dni" id="dni">
                     <span class="input-group-btn ml-1 bg-primary">
                      {!! Form::button('<i class="fa fa-search" id="ibtnConsultar"> Buscar</i>', array('style'=>' height:38px; color:white;','class'=> 'btn  waves-effect waves-light  btn-sm', 'id' => 'btnConsultar')) !!}
                    </span>
                   </div>
                   {{-- <div class="my-2 col-xs-12 col-md-2">
                     <button class="btn btn-primary" type="button" onclick="buscarAlumno();" id="botonBuscar" >Buscar</button>
                   </div> --}}
                   <div class=" my-2 col-xs-12 col-md-6">
                    <input type="text" class="form-control"  placeholder="Nombres y apellidos" name="remitente" id="remitente">
                  </div>
                 </div>

                 <div class="form-row ">
                   <div class=" my-2 col-xs-12 col-md-12">
                     <input type="text" class="form-control"  placeholder="Asunto del trámite" name="asunto" id="asunto">
                   </div>
                 </div>

                 <div class="form-row ">
                   <div class=" my-2 col-xs-12 col-md-12">
                     <textarea style="resize: none; " rows="2" class="form-control"  placeholder="Comentario ..." name="comentario" id="comentario"></textarea>
                   </div>
                 </div>
             
                 <!-- DATOS DEL TUTOR -->
                 <div class="form-row ">
                   <div class=" my-2 col-xs-12 col-md-6">
                     <input type="text" class="form-control"  placeholder="micorreo@gmail.com" name="correo" id="correo">
                     <small class="ml-2 color-blue">Te enviaremos información sobre tu trámite a este correo.</small>
                   </div>
                   <div class=" my-2 col-xs-12 col-md-6">
                     <input type="text" class="form-control"  placeholder="Teléfono/celular" name="telefono" id="telefono">
                   </div>
                   
                 </div>
                 <div class="form-row mt-4">
                   <div class=" my-2 col-xs-12 col-md-6 ml-4"> 
                     <input type="checkbox" class="form-check-input"  value="N"  name="terminosycondiciones" id="terminosycondiciones" onclick="this.value = (this.value=='N')?'S':'N'">
                     <label for="terminosycondiciones" >Acepto los términos y condiciones.</label>
                   </div>
                 </div>
                 <!-- FIN DATOS DEL TUTOR -->

                 <h5>Archivos</h5>
                 <table class="table table-bordered table-hover" id='tabla_archivos'>
                   <thead>
                     <tr>
                       <th width='30%;'>Archivo</th>
                       <th>Descripcion</th>
                       <th width='10%;'>Borrar</th>
                     </tr>
                   </thead>
                   <tbody>
                     <tr>
                       <td width='30%;'>
                         <input type="file" class="form-control-file"  placeholder="Seleccione el archivo" name="file1" id="file1">
                       </td>
                       <td>
                         <input class="form-control" type="text" id='file1_text' name='file1_text'>
                       </td>
                       <td width='10%;'>
                         <button class="btn btn-danger borrar"><i class="fa fa-trash"></i></button>
                       </td>
                     </tr>
                   </tbody>
                   <tfoot>
                     <tr>
                       <td colspan="3"><button id='agregararchivo' class="btn btn-flat btn-secondary" ><i class="fa fa-plus"></i> Agregar archivo</button></td>
                     </tr>
                   </tfoot>
                 </table>
         
                 <div class="text-center mt-4">
                   <button type="submit" class="btn btn-success " id="btnsubmit" style="width:40%;">REGISTRAR TRÁMITE</button>
                 </div>
               </form>
            </div>
         
         
            
          </body>
        </body>
        <script src="{{asset("assets/$theme/plugins/jquery/jquery.min.js")}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
        <script src="{{asset("assets/$theme/dist/js/adminlte.min.js")}}"></script>
        <script src={{asset("js/input-mask/jquery.inputmask/jquery.inputmask.js")}}></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


        <script src={{asset("js/input-mask/jquery.inputmask/jquery.inputmask.extensions.js")}}></script>
        <script src={{asset("js/input-mask/jquery.inputmask/jquery.inputmask.date.extensions.js")}}></script>
        <script src={{asset("js/input-mask/jquery.inputmask/jquery.inputmask.numeric.extensions.js")}}></script>
        <script src={{asset("js/input-mask/jquery.inputmask/jquery.inputmask.phone.extensions.js")}}></script>
        <script src={{asset("js/input-mask/jquery.inputmask/jquery.inputmask.regex.extensions.js")}}></script>

</html>
<script>
  $(document).ready(function(){

      $('#dni').inputmask("numeric");
      $('#telefono').inputmask("numeric");

    });

    var carro = new Array();
    carro.push('file1');
   $( "#pretramite-form" ).submit(function( event ) {
        event.preventDefault();
        $('#listArchivos').val(carro);
        $('#btnsubmit').attr("disabled", true);
// var datos   = $(this).serialize();
        var formData = new FormData($(this)[0]);
        var valido  = $('#terminosycondiciones').val() == 'N' ? false : true;
        if(valido){
            var request = $.ajax({
              url     : '{{route('contribuyente.registrartramite')}}',
              method  : "POST",
              data    : formData,
              processData: false,  // tell jQuery not to process the data
              contentType: false,
              // async: true,
              // headers: {
              //               "cache-control": "no-cache"
              //  },
            });

            request.done(function(msg) {
              respuesta = msg;
            }).fail(function(xhr, textStatus, errorThrown) {
              respuesta = 'ERROR';
            }).always(function() {
              $('#btnsubmit').attr("disabled", false);
              if(respuesta.trim() === 'ERROR'){
              }else {
                if (respuesta.trim() === 'OK') {
                   toastr.success('¡Se ha registrado correctamente su trámite!', 'Realizado con éxito');
                   $('#pretramite-form').addClass('d-none');
                   $('#divMensajeError').html('');
                   $('#divsuccess').removeClass('d-none');
                } else {
                  mostrarErrores(respuesta, '#pretramite-form');
                }
              }
            });
          }else{
            $('#btnsubmit').attr("disabled", false);
            toastr.warning('¡Es necesario que acepte los términos y condiciones!', '');
          }
    });

    
function mostrarErrores (data, idformulario ) {
	try {
		var mensajes = JSON.parse(data);
		var divError = '#divMensajeError';
		$(divError).html('');
		var respuesta = true;
		$(idformulario).find(':input').each(function() {
			var elemento         = this;
			var cadena           = idformulario + " :input[id='" + elemento.id + "']";
			var elementoValidado = $(cadena);
			elementoValidado.parent().removeClass('has-error');
		});
		var cadenaError = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Por favor corrige los siguentes errores:</strong><ul>';
		for(var valor in mensajes){
			var cadena           = idformulario + " :input[id='" + valor + "']";
			var elementoValidado = $(cadena);
			elementoValidado.parent().addClass('has-error');
			var cantidad = mensajes[valor].length;
			for (var i = 0; i < cantidad; i++) {
				if (mensajes[valor][i] != '') {
					cadenaError += ' <li>' + mensajes[valor][i] + '</li>';
				}
			};
		}
		cadenaError += '</ul></div>';
		$(divError).html(cadenaError);
	} catch (e) {
		$('#divMensajeError'+(contadorModal-1)).html(data);
	}
}


$('#btnConsultar').on('click', function(){
  $('#pretramite-form').addClass('d-none');
                   $('#divMensajeError').html('');
                   $('#divsuccess').removeClass('d-none');
			let valor = $('#dni').val();
					if(valor.length == 8){
						consultarDNI();
					}else{
						alert('Ingrese un documento válido');
					}
		});

    function consultarDNI(){
		// 
			$.ajax({
				type: "POST",
				url: "{{route('contribuyente.buscarDNI')}}",
				data: "dni="+$( '#pretramite-form :input[id="dni"]').val()+"&_token="+$('#pretramite-form:input[name="_token"]').val(),
				success: function(a) {
					datos=JSON.parse(a);
						$('#pretramite-form :input[id="remitente"]').val(datos.nombres+' '+datos.apepat+' '+datos.apemat);
				}
			});
    }

    

    $('#agregararchivo').on('click', function(event){
      event.preventDefault();
      var fila = `
                    <tr>
                       <td width='30%;'>
                         <input type="file" class="form-control-file"  placeholder="Seleccione el archivo" name="file${carro.length +1 }" id="file${carro.length +1 }">
                       </td>
                       <td>
                         <input class="form-control" type="text" id='file${carro.length +1 }_text' name='file${carro.length +1 }_text'>
                       </td>
                       <td width='10%;'>
                         <button class="btn btn-danger borrar" ref_id= 'file${carro.length+1}'><i class="fa fa-trash"></i></button>
                       </td>
                     </tr>
        `;

        $('#tabla_archivos').append(fila);
        carro.push('file'+(carro.length + 1));
    });
    $(document).on('click', '.borrar', function (event) {
      event.preventDefault();
      $(this).closest('tr').remove();
      console.log($(this).attr('ref_id'));
      for (let index = 0; index < carro.length; index++) {
          if(carro[index] == $(this).attr('ref_id')){
            carro.splice(index,1);
          }        
      }
    });
</script>

