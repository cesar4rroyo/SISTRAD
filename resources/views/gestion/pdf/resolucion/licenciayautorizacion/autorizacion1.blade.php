<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AUTORIZACIÓN: {{$data->numero}}</title>
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
    <div class=" text-center">
        <h1 style="color: black; font-size:1rem; text-decoration: underline;">AUTORIZACIÓN N° {{$data->numero}}-{{\Carbon\Carbon::now()->year}}-MDJLO-OLyA</h1>
    </div>
    <div style="margin-left: 50px">
        <div>
            <p style="font-size: .8rem; color:black; text-decoration: underline;">VISTO</p>
        </div>
        <div>
            <p style="font-size: .8rem; text-indent:18px">
               <strong> EL EXPEDIENTE NRO. {{$data->tramite->numero}}-{{\Carbon\Carbon::now()->year}}-UTD</strong>, de fecha {{ date_format(date_create($data->tramite->fecha ), 'd/m/Y')}}, presentado 
                por Don(a).- <strong>{{$data->contribuyente}}</strong>, identificado con D.N.I N° {{$data->dni}}  en la cual solictia la regularizacion de la Autorización por la instalación de <strong>ANUNCIO PUBLICITARIO {{$data->claseanuncio}}</strong>, situado en {{$data->direccion}}
                del distrito de José Leonardo Ortiz.
            </p>
            <p style="font-size: .8rem; text-indent:18px">
                Que la Municipalidad de José Leonardo Ortiz, goza de autonomía política, Económica y Administrativa en los asuntos de su competencia, asimismo
                el recurrente se presenta ante esta Municipalidad peticionando la regularizacion de la <strong>AUTORIZACIÓN PARA LA INSTALACIÓN DE AUNUNCIO PUBLICITARIO SIMPLE</strong>, 
                habiendo cumplido con presentar la documentación vigente.
            </p>
            <p style="font-size: .8rem; text-indent:18px">
                Que, de conformidad con las facultades y de acuerdo a las atribuciones conferidas por la Ley Orgánica de las Municipalidades N° 27972, Ley 
                Marco de Licencia de Funcionamiento  N° 28976 y la Ordenanza Municipal N° 0011-2016-MDJLO, de fecha tres de febrero del ańo dos mil diesiséis.
            </p>
        </div>
        <div>
            <p style="font-size: .8rem; color:black;"><strong>SE RESUELVE:</strong></p>
        </div>
        <div>
            <p style="font-size: .8rem; color:black;"><strong>ARTÍCULO PRIMERO: AUTORIZAR </strong> a Don(a).- {{$data->conttibuyente}}, identificado con 
            D.N.I. Nro. {{$data->dni}}, la instalación de <strong> UN ANUNCIO PUBLICITARIO TIPO</strong>, situado en {{$data->direccion}}, el mismo que presenta las 
            siguientes características:</p>
            <table class="tabledatos">
                <tr>
                    <td>
                        <strong>CLASE DE ANUNCIO</strong>
                    </td>
                    <td>
                        <strong>
                            : {{$data->claseanuncio}}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>UBICACIÓN</strong>
                    </td>
                    <td>
                        <strong>: {{$data->ubicacionanuncio}}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>LEYENDA DEL ANUNCIO</strong>
                    </td>
                    <td>
                        <strong>
                            : {{$data->leyenda}}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>ÁREA</strong>
                    </td>
                    <td>
                        <strong>: {{$data->area}}m2</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>DIRECCIÓN</strong>
                    </td>
                    <td>
                        <strong>: {{$data->direccion}}</strong>
                    </td>
                </tr>
            </table>
            <p style="font-size: .8rem; color:black;"><strong>ARTÍCULO SEGUNDO: </strong> La Autorización de la instalación 
                de un Anuncio Publicitario {{$data->claseanuncio}} tendrá una vigencia de {{$data->vigencia}} años, que regirá a partir de la fecha de presentado el expediente, 
                desde el <strong>{{date_format(date_create($data->tramite->fecha ), 'd/m/Y')}}</strong> al <strong>{{date_format(date_create($data->fechavencimiento ), 'd/m/Y')}}.</strong></p>
            <p style="font-size: .8rem; color:black;"><strong>ARTÍCULO TERCERO: </strong> La presente Autorización 
                 está sujeta a fiscalización posterior, debiendo respetar las características estipuladas en el <strong>ARTÍCULO PRIMERO, </strong> caso contrario
                 deberá realizar nuevo trámite el expediente.</p>
            <p style="font-size: .8rem; color:black;"><strong>ARTÍCULO CUARTO:</strong> Remítase la copia del presente a las áreas competentes de la Municipalidad
                para su conocimiento con respecto a la Autorización indicada en el Artículo Primero según su naturaleza.</p>
        </div>
        <div class="float-right">
            <h1 style="font-size:.8rem;">José L. Ortiz, {{ \Carbon\Carbon::parse($data->fechainicial)->formatLocalized('%d %B %Y')}}</h1>
        </div>
        <br>
        <div>
            <p style="font-size: .8rem; color:black;">Email Ref: {{$data->tramite->correo}}</p>
        </div>
    </div>
    
    <footer>
        OFICINA DE LICENCIAS Y AUTORIZACIONES
    </footer>
    
</body>

</html>
