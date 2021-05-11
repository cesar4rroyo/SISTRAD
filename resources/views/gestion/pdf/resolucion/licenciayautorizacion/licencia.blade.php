<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resolucion de Gerencia Nro: {{$data->numero}}</title>
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
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="50"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1rem">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
                <h4 style="font-size: 0.8rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h4>
                <h5 style="font-size: .6rem">PORTAL WEB: www.munijlo.gob.pe</h5>
                <h4 style="font-size: 0.8rem">"AÑO DEL BICENTENARIO DEL PERÚ: 200 AÑOS DE INDEPENDENCIA"</h4>

            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="text-decoration: underline; color: black; font-size:1rem">RESOLUCIÓN DE GERENCIA N° {{$data->numero}}-MDJLO/GDEyS</h1>
    </div>
    <div class=" float-right">
        <h3 style="color: black; font-size:.8rem">JOSE LEONARDO ORTIZ, {{ date_format(date_create($data->fecha ), 'd/m/Y')}}</h3>
    </div>
    <br>
    <div class="ml-5">
        <h3 style="color:black; font-size:.8rem">EL GERENTE DE DESARROLLO ECONÓMICO Y SOCIAL DE LA MUNICIPALIDAD DE JOSE LEONARDO ORTIZ</h3>
    </div>
    <div>
        <h3 style="color:black; font-size:.8rem">VISTO:</h3>
    </div>
    <div>
        <p style="font-size: .8rem; text-indent:18px">
            El Expediente <strong>N° {{$data->nroexpediente}},</strong> presentado por Don (a): <strong>{{$data->contribuyente}}</strong>, mediante
            el cual solicita <strong>LICENCIA DE FUNCIONAMIENTO {{$data->funcionamiento}}</strong>, con giro de <strong>{{$data->girocomercial}}</strong>, denominado
            <strong>{{$data->nombrecomercial}}</strong> ubicado en <strong>{{$data->direccion}}</strong>, del Distrito de José Leonardo Ortiz.
        </p>
    </div>
    <div>
        <h3 style="color:black; font-size:.8rem">CONSIDERANDO:</h3>
    </div>
    <div>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            Que, según lo prescrito por el Artículo 194° de la Constitución Política del Estado, concordante con Artículo II
            del Título Preliminar de la Ley N° 27972 "Ley Orgánica de Municipalidades"; las Municipalidades gozan de autonomía
            económica, política y administrativa en los asuntos de su competencia, la misma que radica en la facultad de ejercer actos
            de gobierno, administrativos y administración con sujeción al ordenamiento jurídico.
        </p>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            Que, las Municipalidades están facultadas a otorgar Licencias para la Apertura de Establecimientos Comerciales, Industriales
             y de Servicios tal como lo establece la Ley N° 27972 "Ley Orgánica de Municipalidades" en su Artículo 83° inciso 3 numeral 3.6, 
             concordante con el Art. 71° del Decreto Legislativo N° 776 - Ley de Tributación Municipal N° 0011-2012-MDJLO y la Ordenanza Municipal
             N°002-2016-MDJLO, de fecha tres de febrero del año 2016. 
        </p>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            Que, mediante Oficio N°026-2021-MDJLO/OLyA, de fecha 16 de Marzo del año 2021, la Oficina de Licencia y Autorizaciones, señala que de acuerdo
            a la documentación presentada por el Administrativo y según la Declaración Jurada de Licencia de Funcionamiento, ocupa un área comercial de 
            {{$data->area}}, por lo que considera procedente otorgar lo solicitado por el recurrente.
        </p>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            Estando a los considerados expuestos a lo informado por la Oficina de Licencias y Autorizaciones y en uso a las facultades delegadas
            al Gerente de Desarrollo Económico y Social mediante la Resolución Gerencial N°047-2021-MDJLO/GM, de fecha 25 de enero del año 2021, concordante
            con la Ley N° 27972, Ley Orgánica de las Municipalidades;
        </p>
    </div>
    <div>
        <h3 style="color:black; font-size:.8rem">SE RESUELVE:</h3>
    </div>
    <div>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            <span><strong>ARTÍCULO PRIMERO:</strong></span> <strong>CONCEDER LA LICENCIA DE FUNCIONAMIENTO DEFINITIVA</strong> recaído en su Serie de Certificado
            <strong>{{$data->nrocertificado}}</strong>, del Establecimiento Comercial con giro de  <strong>{{$data->girocomercial}}</strong>, denominado <strong>{{$data->nombrecomercial}}</strong>,
            ubicado en <strong>{{$data->direccion}}</strong>. Representado por Don(a): <strong>{{$data->contribuyente}}</strong>
        </p>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            <span><strong>ARTÍCULO SEGUNDO:</strong></span> Esta Licencia <strong>{{$data->viapublica}}</strong> le autoriza el <strong>USO DE VIA PÚBLICA.</strong>
        </p>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            <span><strong>ARTÍCULO TERCERO:</strong></span> <strong>ENCARGAR A LA OFICINA DE LICENCIAS Y AUTORIZACIONES,</strong> el control y cumplimiento de la presente Resolución,
            bajo responsabilidad.
        </p>
        <p align="left" style="font-size: .8rem; text-indent:18px; text-align: justify;">
            <span><strong>REGÍSTRESE, COMUNÍQUESE Y CUMPLASE</strong></span> 
        </p>
    </div>
</body>
</html>