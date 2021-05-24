<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DOCUMENTO DE DEFENSA CIVIL N°: {{$data->numero}}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
</head>
<style type="text/css">
   
    .gray {
        background-color: lightgray
    }
    .underline {
        text-decoration: underline;
    }
    .tabledatos td {
        font-size: .8rem;
    }
    .text-general {
        font-size: .8rem;
    }
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="70"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1.5rem; color:red">SUB GERENCIA DE DEFENSA CIVIL</h3>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="color: black; font-size:1rem;">CERTIFICADO DE INSPECCION 
            TECNICA DE SEGURIDAD EN EDIFICACIONES PARA ESTABLECIMIENTOS OBJETO DE INSPECCION CLASIFICADOS
            CON NIVEL DE RIESGO ALTO O MUY ALTO SEGUN LA MATRIZ DE RIESGO</h1>
    </div>
    <div class=" text-center">
        <h1 style="color: black; font-size:1rem;"> N° {{$data->numero}} - {{date('Y')}}</h1>
    </div>
    <div class="" style="line-height: 90%">
        <p style="font-size: .9rem;">El órgano ejecutante de la Municipalidad Distrital de José Leonardo Ortiz, en cumplimiento de lo establecido
            en el D.S. 002-2018-PCM, ha realizado la Inspección Técnica de Seguridad en Edificaciones al establecimiento objeto de
            Inspección.
        </p>
    </div>
    <div class=" text-center">
        <h1 style="color: black; font-size:1.2rem;">{{$data->razonsocial}}</h1>
    </div>
    <div class="" style="line-height: 90%">
        <p style="font-size: .8rem;">Ubicado en: <strong>{{$data->direccion}}</strong>
        </p>
        <p style="font-size: .8rem;">Distrito: <strong>{{'JOSÉ LEONARDO ORTIZ'}}</strong>
        </p>
        <p style="font-size: .8rem;">Provincia: <strong>{{'CHICLAYO'}}</strong>, Departamento : <strong>{{'LAMBAYEQUE'}}</strong>
        </p>
        <p style="font-size: .8rem;">Solicitado por: <strong>{{$data->contribuyente}}</strong>
        </p>
        <p style="font-size: .8rem;">El que suscribe: <strong>{{'CERTIFICA'}}</strong>, que el establecimiento objeto de inspección antes señalado
            <strong> CUMPLE CON LAS CONDICIONES DE SEGURIDAD.</strong>
        </p>
        <p style="font-size: .8rem;">Capacidad máxima de la Edificación: <strong>{{$data->capacidadmaxima . ' PERSONAS'}}</strong>
        </p>
        <p style="font-size: .8rem;">Giro o Actividad de la Edificación: <strong>{{$data->girocomercial}}</strong>
        </p>
        <p style="font-size: .8rem;">Área de la Edificación: <strong>{{$data->area . ' m2'}}</strong>
        </p>
        <br>
        <p style="font-size: .8rem;">Expediente Nro.: <strong>{{$data->tramite->numero}} de fecha {{ date_format(date_create($data->tramite->fecha ), 'd/m/Y')}}</strong>
        <p style="font-size: .8rem;"><strong>VIGENCIA 2 AÑOS (*)</strong>
    </div>
    <div style="font-size: .8rem;" class=" float-right">
        <strong>Lugar: JOSÉ LEONARDO ORTIZ</strong>
    </div>
    <br>
    <div style="font-size: .8rem;" class=" float-right">
        <strong>FECHA DE EXPEDICIÓN:{{ date_format(date_create($data->fechaexpedicion ), 'd/m/Y')}}</strong>
    </div>
    <br>
    <div style="font-size: .8rem;" class=" float-right">
        <strong>FECHA DE SOLICITUD DE RENOVACION: {{ date("d/m/Y",strtotime($data->fechavencimiento."- 1 month")) }}</strong>
    </div>
    <br>
    <div style="font-size: .8rem;" class=" float-right">
        <strong>FECHA DE CADUCIDAD: {{ date_format(date_create($data->fechavencimiento ), 'd/m/Y')}}</strong>
    </div>
    <br>
    <br>
    <br>
    <div>
        <p style="font-size: .7rem;"><strong>"EL PRESENTE CERTIFICADO IT SE NO CONSTITUYE AUTORIZACION ALGUNA PARA EL FUNCIONAMIENTO DEL OBJETO DE LA PRESENTE ISNPECCION"</strong>
    </div>
    
    <div style="font-size: .7rem;">
        <p style="font-size: .7rem;"><strong>NOTA:</strong>
        <ul>
            <li>DE ACUERDO A LO ESTBLECIDO EN EL REGLAMENTO DE INSPECCIONES TÉCNICAS DE SEGURIDAD EN EDIFICACIONES APROBADAS POR EL DECRETO
                SUPREMO Nro. 002-2018 PCM, EL PRESENTE CERTIFICADO DEBERÁ SER FIRMADO POR EL RESPONSABLE DEL ÓRAGANO EJECUTANTE.
            </li>
            <li>
                ESTE CERTIFICADO DEBERÁ COLOCARSE EN UN LUGAR VISIBLE DENTRO DEL ESTABLECIMIENTO OBJETO DE INSPECCION.
            </li>
            <li>
                CUALQUIER TACHA O ENMENDADURA INVALIDAD EL PRESENTE CERTIFICADO.
            </li>
        </ul>
        <p>(*) VIGENCIA ESTABLECIDA EN EL ARTÍCULO ÚNICO DE LA LEY N. 30619.</p>
    </div>
 
</body>

</html>