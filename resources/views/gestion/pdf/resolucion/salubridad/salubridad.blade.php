<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resolucion Salubridad Nro: {{$data->numero}}</title>
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
                <h4 style="font-size: 1.1rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h4>
                <h5 style="font-size: 1rem">PORTAL WEB: www.munijlo.gob.pe</h5>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="color: red; font-size:1.5rem">CERTIFICADO DE SALUBRIDAD</h1>
    </div>
    <div class="ml-5">
        <h3 style="text-decoration: underline; color:red; font-size:1rem">LA MUNICIPALIDAD DISTRITAL DE JOSÉ LEONARDO ORTIZ CERTIFICA:</h3>
    </div>
    <div>
        <p style="font-size: .9rem; text-indent:18px">
            El presente Certificado de Salubridad se otorga en concordancia y en conformidad con los establecido
            en la Normatividad Legal Vigente y en aplicación a lo previsto en la: <strong>LEY N° 27972</strong> - Ley
            Orgánicas de Municipalidades: LEY N° 29571 - Ley Protección de Defensa del Consumidor, D.L. N° 1062
            Ley de Inocuidad de los Alimentos, <strong>D.S.N° 007-98-SA.</strong> - Vigilancia y Control sanitario de Alimentos y
            Bebidas, <strong>D.S.N° 022-2001-SA.</strong> - Reglamento Sanitario para las actividades de Saneamiento Ambiental
            de Viviendas y Establecimientos Comerciales, Industriales y de Servicios y el <strong>D.S N°015-2012-AG.</strong> - Reglamento
            Sanitario del faenado de Animales de Abasto: <strong>D.S N° 004-2011-AG. </strong> - Reglamento de 
            inocuidad Agroalimentaria; R.M <strong> N° 282-2003-SA/DM </strong> - Reglamento Sanitario de Funcionamiento de 
            Mercados de Abasto; y otras normas y/o reglamentos afines, se Otorga a:
        </p>
    </div>
    <div class="ml-5">
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>NOMBRE DEL TITULAR: </strong>
                </td>
                <td class="underline">
                    {{$data->contribuyente}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>DIRECCION: </strong>
                </td>
                <td class="underline">
                    {{$data->direccion}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>LOCALIDAD (URB - PJ): </strong>
                </td>
                <td class="underline">
                    {{$data->localidad}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>EXPEDIENTE N°: </strong>
                </td>
                <td class="underline">
                    {{$data->numero}}
                </td>
                <td>
                    <strong>
                        CATEGORIA: 
                    </strong>
                </td>
                <td class="underline">
                    {{$data->categoria}}
                </td>
                <td>
                    <strong>
                        ZONA: 
                    </strong>
                </td>
                <td class="underline">
                    {{$data->zona}}
                </td>
            </tr>           
        </table>
        <p style="font-size: 0.9rem">Que Habiéndose verificado los requisitos Sanitarios estipulados en el Decreto antes señalado
            que normam el funcionamiento de los Locales destinados para Establecimientos Públicos
        </p>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>RAZON SOCIAL:</strong>
                </td>
                <td class="underline">
                    {{$data->razonsocial}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>GIRO COMERCIAL:</strong>
                </td>
                <td class="underline">
                    {{$data->girocomercial}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>FECHA DE EXPEDICION: </strong>
                    <td class="underline">
                        {{ date_format(date_create($data->fechaexpedicion ), 'd/m/Y')}}
                    </td>
                </td>
                <td>
                    <strong>FECHA DE VENCIMIENTO: </strong>
                    <td class="underline">
                        {{ date_format(date_create($data->fechavencimiento ), 'd/m/Y')}}
                    </td>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <p style="font-size: .55rem; color:red">
            NOTA: SI REALIZA ALGUNA MODIFICACIÓN O CIERRE DE ACTIVIDAD DEBERÁ COMUNICAR O CANCELAR
            DEFINITIVAMENTE LA AUTORIZACIÓN ASIMISMO EXHIBIRÁ EN LUGAR VISIBLE EL ORIGINAL BAJO RESPONSABILIDAD
            DEL ADMINISTRADO PERMITIENDO FISCALIZACIÓN DEL MISMO TAL COMO LO ESTABLECE LA LEY 2744 Y LA LEY 28976
            PARA EVITAR SER SANCIONADO DE DETECTARSE ALGUN DATO FRAGUADO
        </p>
    </div>
    
</body>

</html>