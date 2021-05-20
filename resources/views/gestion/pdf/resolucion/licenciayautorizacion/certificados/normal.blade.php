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
        font-size: 0.8rem;
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
                <h1 style="color: black; font-size:1.3rem; font-family:Arial, Helvetica, sans-serif">LICENCIA DE FUNCIONAMIENTO {{$data->funcionamiento}}</h1>
            </td>
        </tr>
    </table>
    <hr>
    <div class="ml-5">
        <table class="tabledatos2 tabledatos">
            <tr>
                <td>
                    <strong>JOSE L. ORTIZ {{ date_format(date_create($data->tramite->fecha ), 'd/m/Y')}}</strong>
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
                    <strong>EXPEDIENTE N° {{$data->tramite->numero}}</strong>
                </td>
                <td>
                    <strong>AREA {{$data->area . ' M2'}}</strong>
                </td>
                <td>
                    <strong>{{'X ' . $data->tipopersona}}</strong>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="ml-5">
        <h3 style="color:black; font-size:0.9rem">LA MUNICIPALIDAD DISTRITAL DE JOSÉ LEONARDO ORTIZ CERTIFICA:</h3>
    </div>
    <div class="ml-5">
        <p style="font-size: 0.9rem;">
            La presente Licencia se otorga en concordancia con lo establecido en la normatividad Legal Vigente y en Aplicación a lo previsto en la Ley 
            N° 27972 Ley Orgánica de Municipalidades: Ley 28976 Ley Marco de Lic. De funcionamiento. Otorga a:
        </p>
    </div>
    <div class="ml-5">
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>NOMBRE O RAZON SOCIAL: </strong>
                </td>
                <td class="">
                    {{$data->contribuyente}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong> </strong>
                </td>
                <td class="">
                    {{$data->razonsocial}}
                </td>
            </tr>
            
        </table>
        <br>
        <p style="font-size: 0.9rem">QUIEN HABIENDO CUMPLIDO CON PRESENTAR LOS REQUISITOS CORRESPONDIENTES PARA EL FUNCIONAMIENTO DE
        </p>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>GIRO </strong>
                </td>
                <td class="">
                    <span style="color:white">AAAAAAAAAAAAAAAA</span>
                    {{$data->girocomercial}}
                </td>
            </tr>
        </table>
        <table class="tabledatos">
            
                <tr>
                    <td style="color:white">
                        <strong>NOMBRE O RAZON SOCIAL: </strong>
                    </td>
                    <td class="">
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
        </table>
    </div>
    <br>
    <div>
        <p style="font-size: .65rem; color:black">
           <strong>
            NOTA: SI REALIZA ALGUNA MODIFICACIÓN O CIERRE DE ACTIVIDAD DEBERÁ COMUNICAR O CANCELAR
            DEFINITIVAMENTE LA AUTORIZACIÓN SEGUN LO ESTABLECE LA LEY DE MARCO DE LICENCIA. DEBE EXHIBIR EL ORIGINAL DE LA LICENCIA
            BAJO RESPONSABLIDAD DEL ADMINISTRADO PERMITIENDO FISCALIZACIÓN DEL MISMO TAL COMO LO ESTABLECE LA LEY 2744 Y LA LEY 28976
            PARA EVITAR SER SANCIONADO O CLAUSURADO DE DETECTARSE ALGUN DATO FRAGUADO. ESTA AUTORIZACIÓN {{$data->viapublica}} AUTORIZA 
            EL USO DE LA VIA PUBLICA.
           </strong>
        </p>
    </div>
    <div class="ml-5">
        <table class="table2 tabledatos">
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr>
                <td>________________________________
                    <span style="color:white">AAAAAAAAAA</span>
                </td>
                <td>
                    <span style="color:white">AAAAAAA</span>
                    ___________________________________________</td>
            </tr>
            <tr>
                <td>
                    <span style="color:white">AAAAA</span>
                    GERENTE MUNICIPAL</td>
                <td>
                    <span style="color:white">AAAAAAAA</span>
                    OFICINA DE LICENCIAS Y AUTORIZACIONES</td>
            </tr>
        </table>
    </div>
    <img class=" float-right" src="data:image/svg+xml;base64,{{ base64_encode($codigoQR) }}">
    <footer class="text-center" style="font-size: .8rem">
        <p>AV. SAENZ PEÑA N°2151 - URB. LATINA. TLF. 257521-TELFAX 074253882 JOSE L. ORTIZ-CHICLAYO </p>
    </footer>
    
</body>

</html>