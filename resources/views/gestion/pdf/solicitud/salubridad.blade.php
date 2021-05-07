<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Solicitud de Salubridad Nro: {{$data->numero}}</title>
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
    .tabledatos tr td{
        font-size: 0.8rem;
    }
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="80"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1.3rem">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
                <h4 style="font-size: 1.1rem">PROVINCIA - CHICLAYO </h4>
                <h5 style="font-size: 1rem">SUB GERENCIA DE PROMOCIÓN DE LA SALUD Y SANIDAD</h5>
            </td>
        </tr>
    </table>
    <hr>    
    <div class="ml-5">
        <p class=" font-weight-bold" style="font-size: .8rem;">I. DATOS DEL SOLICITANTE</p>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>SOLCITANTE: </strong>
                </td>
                <td class="underline">
                    {{$data->contribuyente}}
                </td>
                <td>
                    <strong>Nro. DNI</strong>
                </td>
                <td class="underline">
                    {{$data->dni}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>REPRESENTANTE LEGAL: </strong>
                </td>
                <td class="underline">
                    {{$data->representante}}
                </td>
                <td>
                    <strong>TELÉFONO</strong>
                </td>
                <td class="underline">
                    {{$data->telefono}}
                </td>
            </tr>                   
        </table>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>DIRECCION: </strong>
                </td>
                <td class="underline">
                    {{$data->direccion}}
                </td>
            </tr>
        </table>
        <br>
        <p class=" font-weight-bold" style="font-size: .8rem;">II. AUTORIDAD O FUNCIONARIO AL QUE VA DIRIGO LA SOLICITUD</p>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>A: </strong>
                </td>
                <td class="underline">
                    @if ($data->funcionario=='Funcionario')
                        {{'FUNCIONARIO MUNICIPAL: SR. PABLO ROMERO ZAPATA'}}
                    @else
                        {{'ALCALDE: WILDER GUEVARA DIAZ'}}
                    @endif
                </td>              
            </tr>
            <tr>
                <td><strong>CARGO:</strong> </td>
                <td class="underline">
                    SUB GERENCIA DE PROMOCIÓN DE LA SALUD Y SALUBRIDAD
                </td>
            </tr>
        </table>
        <br>
        <p class=" font-weight-bold" style="font-size: .8rem;">III. SOLICITO</p>
        <p style="font-size: .8rem;">QUE SE ME EXPIDA EL CERTIFICADO DE SALUBRIDAD <span class=" text-uppercase font-weight-bold">({{$data->solicito}})</span>, DE 
        MI NEGOCIO DENOMINADO: <strong>{{$data->nombrenegocio}}</strong>, CON GIRO: <strong>{{$data->girocomercial}}</strong>, CON RAZON SOCIAL: <strong>{{$data->razonsocial}}</strong>, EN LA 
        DIRECCIÓN ANTES INDICADA.</p>
        <br>
        <p class=" font-weight-bold" style="font-size: .8rem;">IV. DATOS ANEXOS</p>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>RECIBO DE PAGO NRO.</strong>
                </td>
                <td class="underline">
                    {{$data->ordenpago->numero}}
                </td>
            </tr>
            @if ($data->solicito=='Renovacion')
                <tr>
                    <td>
                        <strong>CERTIFIACADO DE SALUBRIDAD NRO.</strong>
                    </td>
                    <td class="underline">
                        {{$data->nrocertificado}}
                    </td>
                </tr> 
            @endif
        </table>
        <br>
        <p style="font-size: .8rem;">LA INFORMACION Y LOS DATOS CONSIGNADOS TIENEN EL CARACTER DE DECLARACION JURADA.
         SOMETIENDOME A LAS SANCIONES DE LEY EN CASO DE FALSEDAD U OMISION FIRMADO Y ESTAMPANDO MI HUELLA DIGITAL EN SEÑAL DE CONFORMIDAD</p>
         <br>
         <br>
         <div class=" font-weight-bold" style="font-size: .8rem">
            <span>_________________________________</span><br>
            <p class="ml-5">FIRMA DEL SOLICITANTE</p>
        </div>
    </div>
   
    <div class=" float-right">
        <p class=" font-weight-bold" style="font-size: .8rem">JOSE, L. ORTIZ, {{date_format(date_create($data->fecha) ,'d/m/Y')}}</p>    
    </div>   
    
</body>

</html>