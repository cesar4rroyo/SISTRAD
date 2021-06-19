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
    .divdatos{
        position: fixed;
        bottom: -60px; 
        left: 0px; 
        right: 0px;
        height: 200px;

    }

    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
    overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
    font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}

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

    .cuadro{
        position: absolute;
        top: 2;
        right: -75;
    }

</style>

<body>
    @php
        if(str_contains($data->tipotramitesolicitud, 'Licencia de Funcionamiento para Bodegas')){
            $bg='warning';
        }else{
            $bg=null;
        }
    @endphp
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="50"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ CHICLAYO LAMBAYEQUE</h3>
                {{-- <h4 style="font-size: .8rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h4> --}}
                {{-- <h4 style="font-size: .8rem">www.munijlo.gob.pe</h4> --}}
                <h5 style="font-size: .8rem">OFICINA DE LICENCIAS Y AUTORIZACIONES</h5>
                
            </td>
        </tr>
    </table>
    
    <div class="cuadro">
        <img src="http://assets.stickpng.com/images/58afdac9829958a978a4a691.png" alt="" height="300">
    </div>
    @if ($bg)
        <div class="ml-5">
            <div class="ml-5">
                <div class="ml-5">
                    <div class="text-center ml-5">
                        <div class=" text-center ml-5" style="width: 50%">
                            <h5 class=" bg-warning" style="font-size: .8rem">FORMATO DE DECLARACION JURADA PROVISIONAL <br> DE  FUNCIONAMIENTO PARA BODEGAS</h5>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <hr>
    <div class="">
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
        <div style="font-size: .8rem; margin-left:18px; line-height:120%">
            <p><strong>APELLIDOS Y NOMBRES:</strong> {{$data->nombresolicitante}}</p>
            <p><strong>DNI:</strong> {{$data->dni}}</p>
            <p><strong>RUC:</strong> {{$data->ruc}}</p>
            <p><strong>TELEFONO:</strong> {{$data->telefonosolicitante}}</p>
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
        <div style="font-size: .8rem; margin-left:18px; line-height:80%">
            @php
                $arr = explode('===', $data->requisitos);
            @endphp
            @foreach ( $arr as $item)
                @if ($item!='')
                    <p>{{$loop->iteration . '.- '}} {{$item}}</p>
                @endif
            @endforeach
        </div>
        <br>
        @if ($data->tipoanuncio!='' || $data->tipoanuncio!=null)
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
        @endif
        @if ($data->nroexpediente!='' || $data->nroexpediente!=null)
            <p class=" font-weight-bold" style="font-size: .8rem; text-indent:18px; line-height:50%; text-decoration:underline">
            VII.- DUPLICADO DE LICENCIA DE FUNCIONAMIENTO
            </p>
            <div style="font-size: .8rem; text-indent:18px; line-height:80%">
                <p><strong>Nro. De Expediente</strong> {{$data->nroexpediente}}</p>
                <p><strong>Nro. De Cartón</strong> {{$data->nrocertificado}}</p>
                <p><strong>Nro. De Resolución</strong> {{$data->nroresolucion}}</p>
            </div>
        @endif
            <table class="tg divdatos" align="right">
                <thead>
                  <tr>
                    <th class="tg-0pky"></th>
                    <th class="tg-0pky"><br></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="tg-0pky">Firma del Solicitante</td>
                    <td class="tg-0pky" rowspan="2">HUELLA</td>
                  </tr>
                  <tr>
                    <td class="tg-0pky">DNI Nº ................</td>
                  </tr>
                </tbody>
            </table>
        
    <footer>
        OFICINA DE LICENCIAS Y AUTORIZACIONES
    </footer>
    
</body>

</html>
