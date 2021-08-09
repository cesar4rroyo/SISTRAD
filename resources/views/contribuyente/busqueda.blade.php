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
                
                <div class="card-header " style="background:#0ac9bd; color:white;"> 
                    <h3 class="card-title">CONSULTA EL ESTADO DE TU TRÁMITE</h3>
                </div>
                <div id="divMensajeError"></div>
                <form class="m-4" id="busqueda-form">
                 <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                 <!-- DATOS DEL ESTUDIANTE-->
                 <blockquote class="m-2 " >
                    <p  style="color: rgb(25, 64, 205); font-style:italic;">*Recuerda que al enviar la solicitud esta puede ser aprobada o rechazada, en caso de ser aprobada se creará un trámite el cual tiene un proceso interno el cual puedes seguir desde esta misma página.</p>
                  </blockquote>
                 <blockquote class="m-2 " >
                   <p  style="color: rgb(25, 64, 205); font-style:italic;">*Ingrese el número de la solicitud, este fue enviado a su correo al momento de realizar la solicitud de registro del trámite.</p>
                 </blockquote>
                 <h5 class="mt-5">Ingrese los datos solicitados</h5>
                 <div class="form-row ">
                    <div class=" my-2 col-xs-12 col-md-4">
                        <select class="form-control"  name="tipo" id="tipo" >
                            <option value="virtual" selected>Modalidad virtual</option>
                            <option value="presencial" >Modalidad Presencial</option>
                        </select>
                      </div>
                    
                   <div class=" my-2 col-xs-12 col-md-4 ">
                     <input type="text" class="form-control"  placeholder="Número" name="numero" id="numero">
                   </div>
                   <div class=" my-2 col-xs-12 col-md-4">
                    <input type="text" class="form-control"  placeholder="DNI" name="dni" id="dni">
                  </div>
                 </div>
                
                 <div class="form-row">
                     <div class="captcha m-4 col-md-4 offset-md-2 text-right">
                         <span>{!!captcha_img('math')!!}</span>
                         <button type="button" class="btn btn-success btn-refresh">Refresh</button>
                     </div>
                     <div class="col-md-4 m-4">
                     <input class="form-control" type="text" name="captcha" id="captcha" placeholder="Ingrese el resultado de la operación">
                     </div>
                 </div>
                 <button class="btn btn-primary btn-block" id='btnConsultar'><i class="fa fa-search" id="ibtnConsultar"> </i> CONSULTAR TRÁMITE</button>
                 
               </form>

                
            </div>
         
            <div  class="mx-4" id ='divrespuesta'>
                
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

    });
    $('#btnConsultar').on('click', function(event){
        event.preventDefault();
        var numero = $('#numero').val();
        var dni = $('#dni').val();
        if(numero && numero != '' && dni && dni != ''){
            cargarRuta("{{route('contribuyente.buscartramite')}}" , 'divrespuesta');
        }else{
            alert('Ingrese los datos solicitados');
        }

    });
    $('#tipo').on('change', function(){
        verificarTipo();
    });

    $('.btn-refresh').on('click', function(){
        $.ajax({
            type : 'GET',
            url : '{{route('refresh')}}',
            success: function(data){
                $('.captcha span').html(data);
            }
        });
    });

    function verificarTipo(){
        var tipo = $("#tipo").val();
        console.log(tipo);
        if(tipo == 'virtual'){
            $('#dni').removeClass('d-none');
        }else{
            $('#dni').addClass('d-none');
        }
    }
    function sendRuta(ruta){
        var tipo = $('#tipo').val();
        var numero = $('#numero').val();
        var dni = $('#dni').val();
        var captcha = $('#captcha').val();

        var respuesta = $.ajax({
            url : ruta,
            data: {numero , dni , captcha , tipo},
            type: 'GET'
        });
        return respuesta;
    }

    function cargarRuta(ruta, idContenedor) {
        var contenedor = '#' + idContenedor;
        $(contenedor).html(`
        <div class="alert alert-secondary" role="alert">
            Un momento, su solicitud se está procesando ....
            </div>
        `);
        var respuesta = '';
        var data = sendRuta(ruta);
        data.done(function(msg) {
            respuesta = msg;
        }).fail(function(xhr, textStatus, errorThrown) {
            respuesta = 'ERROR';
        }).always(function() {
            if(respuesta === 'ERROR'){
                $(contenedor).html('ERROR');
            }else{
                try {
                    const data = JSON.parse(respuesta);
                    var mensaje = data.captcha[0] =='validation.captcha' ?'El captcha ingresado no coincide' : 'Por favor ingrese el captcha.'
                    // Do your JSON handling here
                    $(contenedor).html(`
                        <div class="alert alert-danger" role="alert">
                            ${mensaje}
                            </div>
                        `);    
                } catch(err) {
                // It is text, do you text handling here
                $(contenedor).html(respuesta);    
                }
            }
        }); 
    }

</script>

