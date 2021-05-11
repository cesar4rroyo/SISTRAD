<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Notificación: {{$data->numero}}</title>
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

    footer {
        position: fixed; 
        bottom: -60px; 
        left: 0px; 
        right: 0px;
        height: 50px;
        /** Extra personal styles **/
        /* background-color: #03a9f4; */
        color: black;
        text-align: center;
        line-height: 35px;
    }
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="50"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ CHICLAYO LAMBAYEQUE</h3>
                <h4 style="font-size: .8rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h4>
                <h4 style="font-size: .8rem">www.munijlo.gob.pe</h4>
                <h5 style="font-size: .8rem">"AÑO DEL BICENTENARIO DEL PERÚ 200 AÑOS DE INDEPENDENCIA"</h5>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" float-right">
        <h1 style="font-size:.8rem;">José L. Ortiz, {{ \Carbon\Carbon::parse($data->fechainicial)->formatLocalized('%d %B %Y')}}</h1>
    </div>
    <br>
    <div>
        <p style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        CARTA N° {{$data->numero}}-MDJLO/OLyA.
        </p>
        <p style="font-size: .8rem; text-indent:18px; line-height:50%">
        Sr.
        </p>
        <p style="font-size: .8rem; text-indent:18px; line-height:50%">
        {{$data->destinatario}}
        </p>
        <p style="font-size: .8rem; text-indent:18px; line-height:50%">
        {{$data->razonsocial}}
        </p>
        <p style="font-size: .8rem; text-indent:18px; line-height:50%">
        {{$data->direccion}}
        </p>
        <p style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
            Presente.-
        </p>
        <div class="ml-5">
            <table class="tabledatos">
                <tr>
                    <td>ASUNTO:</td>
                    <td>{{$data->asunto}}</td>
                </tr>
                <tr>
                    <td>REF:</td>
                    <td>{{'Inspección Nro. ' . $data->inspeccion->numero }}</td>
                </tr>
            </table>
            <br>
            <p style="font-size: .8rem; text-indent:18px;">
                De mi especial consideración:
            </p>
            @foreach ($cuerpo as $p)
            <div style="font-size: .8rem; text-indent:18px;">
               {{$p}}
            </div>
            <br>   
            @endforeach
            
        </div>
    </div>
    <footer>
        OFICINA DE LICENCIAS Y AUTORIZACIONES
    </footer>
    
</body>

</html>
