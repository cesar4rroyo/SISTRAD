<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Solicitud: {{$data->numero}}</title>
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
                <h5 style="font-size: .8rem">OFICINA DE LICENCIAS Y AUTORIZACIONES</h5>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" float-right">
        <h1 style="font-size:.8rem;">José L. Ortiz, {{ date_format(date_create($data->fecha ), 'd/m/Y')}}</h1>
    </div>
    <br>
    <div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        I.- TIPO DE TRAMITE QUE SE SOLICITA:
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:50%">
            <p>- {{$data->tiposolicitud}}</p>
            @foreach (explode('-',$data->tipotramitesolicitud) as $item)
                <p>- {{$item}}</p>
            @endforeach
        </div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        II.- IDENTIFICACIÓN DEL SOLICITANTE:
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:80%">
            <p><strong>APELLIDOS Y NOMBRES:</strong> {{$data->nombresolicitante}}</p>
            <p><strong>DNI:</strong> {{$data->dni}}</p>
            <p><strong>RUC:</strong> {{$data->ruc}}</p>
            <p><strong>RAZON SOCIAL: </strong>{{$data->razonsocial}}</p>
            <p><strong>DIRECCION: </strong>{{$data->direccion}} - <strong>Numero:</strong> {{$data->numerocasa}} 
                - <strong>Manzana:</strong> {{$data->manzanacasa}} - <strong>Lote:</strong> {{$data->casa}} - <strong>Urbanización:</strong> {{$data->urbanizacion}}</p>
        </div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        III.- REPRESENTANTE LEGAL:
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:80%">
            <p><strong>APELLIDOS Y NOMBRES:</strong> {{$data->representantelegal}}</p>
            <p><strong>DNI:</strong> {{$data->dnirepresentante}}</p>
            <p><strong>RUC:</strong> {{$data->rucrepresentante}}</p>
            <p><strong>TELEFONO: </strong>{{$data->telefonorepresentante}}</p>
        </div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        IV.- DATOS DEL ESTABLECIMIENTO:
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:80%">
            <p><strong>NOMBRE COMERCIAL:</strong> {{$data->nombrenegocio}}</p>
            <p><strong>GIRO COMERCIAL:</strong> {{$data->girocomercial}}</p>
            <p><strong>ÁREA TOTAL:</strong> {{$data->area}}</p>
        </div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        V.- REQUISITOS Y/O DOCUMENTOS QUE SE ANEXAN A ESTA SOLICITUD:
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:80%">
            @foreach (explode('-', $data->requisitos) as $item)
                <p>- {{$item}}</p>
            @endforeach
        </div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        VI.- TRÁMITES ADICIONALES SOBRE ANUNCIOS PUBLICITARIOS:
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:80%">
            <p><strong>Solicito publicidad exterior de aviso adosado a fachada: </strong> {{$data->publicidadexterior}}</p>
            <p><strong>Colores del Anuncio</strong> {{$data->colores}}</p>
            <p><strong>Tipo de Anuncio</strong> {{$data->tipoanuncio}}</p>
            <p><strong>Medidas del Anuncio</strong> {{$data->medidad}}</p>
            <p><strong>Leyenda del Anuncio</strong> {{$data->leyendas}}</p>
            <p><strong>Materiales del Anuncio</strong> {{$data->materiales}}</p>
            <p><strong>Cantidad de Anuncios</strong> {{$data->cantidadanuncios}}</p>
        </div>
        <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
        VII.- DUPLICADO DE LICENCIA DE FUNCIONAMIENTO
        </p>
        <div style="font-size: .8rem; text-indent:18px; line-height:80%">
            <p><strong>Nro. De Expediente</strong> {{$data->nroexpediente}}</p>
            <p><strong>Nro. De Cartón</strong> {{$data->nrocertificado}}</p>
            <p><strong>Nro. De Resolución</strong> {{$data->nroresolucion}}</p>
        </div>
        
    <footer>
        OFICINA DE LICENCIAS Y AUTORIZACIONES
    </footer>
    
</body>

</html>
