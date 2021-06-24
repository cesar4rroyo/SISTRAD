<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificado Nro: {{$data->numero}}</title>
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
        font-size: 1rem;
    }
    .tabledatos3 tr td{
        font-size: 0.9rem;
    }
    .tabledatos2{
        width: 100%;
    }
    footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                text-align: center;
                line-height: 35px;
            }
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="65"/>
            </td>
            <td align="center">
                <h1 style="color: red; font-size:1.4rem; font-family:Arial, Helvetica, sans-serif">MUNICIPALIDAD DISTRITAL DE JOSÉ LEONARDO ORTIZ</h1>
                <h1 style="color: black; font-size:1.3rem; font-family:Arial, Helvetica, sans-serif">LICENCIA DE FUNCIONAMIENTO PROVISIONAL</h1>
            </td>
        </tr>
    </table>
    <hr>
    <div class="ml-5">
        <table class="tabledatos2 tabledatos3">
            <tr>
                <td>
                    <strong>EXPEDIENTE N° {{$data->tramite->numero}} {{'   '}} DE: {{date_format(date_create($data->tramite->fecha ), 'd/m/Y')}} </strong>
                </td>
                <td>
                    <strong>RESOLUCION N°  {{$data->numero}} DE {{date_format(date_create($data->fechaexpedicion ), 'd/m/Y')}}</strong>
                </td>
                <td>
                    <strong>CERTIFICADO N°  {{$data->nrocertificado}}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>AREA {{$data->area . ' M2'}}</strong>
                </td>
                <td>
                    <strong>HORARIO DE ATENCION:  {{$data->desdehora . ''}} A {{$data->hastahora}}</strong>
                </td>
                <td>
                    <strong>{{'X ' . $data->tipopersona}}</strong>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="ml-5">
        <p style="font-size: 0.9rem;">
            QUE HABIENDO CUMPLIDO CON LOS REQUISITOS EXIGIDOS PARA OBTENER LA LICENCIAN DE FUNCIONAMIENTO SEGÚN LA LEY Nº 27444
            - LEY DE PROCEDIMIENTO ADMINISTRATIVO aprobado mediante D.S. Nº 004-2019, LEY Nº 30877 - Ley General de Bodegueros y su 
            Reglamento.
            <br>
            SE CONCEDE EL PRESENTE CERTIFICADO A:
        </p>
    </div>
    <br>
    <div class="ml-5">
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>NOMBRE DEL TITULAR: </strong>
                </td>
                <td class="">
                    {{$data->contribuyente}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>DIRECCION: </strong>
                </td>
                <td class="">
                    {{$data->direccion}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>LOCALIDAD: </strong>
                </td>
                <td class="">
                    {{explode('-', $data->direccion)[2]}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>RAZON SOCIAL</strong>
                </td>
                <td class="">
                    {{$data->razonsocial}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ACTIVIDAD (GIRO COMERCIAL): </strong>
                </td>
                <td class="">
                    {{$data->girocomercial}}
                </td>
            </tr>
            
            
        </table>
        <br>
       
    </div>
    <br>
    <br>
    <div class="ml-5">
        <table class="table2 tabledatos">
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr>
                <td>__________________________________________________
                    <span style="color:white">AAAA</span>
                </td>
                <td>
                    <span style="color:white">AAA</span>
                    ___________________________________________</td>
            </tr>
            <tr>
                <td>
                    <span style="color:white">AAAAA</span>
                    GERENTE DESARROLLO ECONÓMICO Y SOCIAL</td>
                <td>
                    <span style="color:white">AAAAAAAA</span>
                    OFICINA DE LICENCIAS Y AUTORIZACIONES</td>
            </tr>
        </table>
    </div>
    <img class=" float-right" src="data:image/svg+xml;base64,{{ base64_encode($codigoQR) }}">
    {{-- <img class=" float-right" src="data:image/svg+xml;base64,{{ base64_encode($codigoQR) }}"> --}}
    <footer class="text-center" style="font-size: .8rem">
        <p>AV. SAENZ PEÑA N°2151 - URB. LATINA. TLF. 257521-TELFAX 074253882 JOSE L. ORTIZ-CHICLAYO </p>
    </footer>
    
</body>

</html>