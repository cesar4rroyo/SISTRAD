<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Notificacion de imputación de cargo: {{$notificacioncargo->numero}}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
</head>
<style type="text/css">
    body {
        font-family: sans-serif;
        font-size: 13px;
    }
   
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

    .bold{
        font-weight: bold;
    }

    .center{
        text-align: center;
    }

    .bordered {
        border: 1px solid black;
    }
    .py-5{
        padding: 0px 5px;
    }
    .py-8{
        padding: 0px 8px;
    }
    .fz-11{
        font-size: 11.5px;
    }
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="50"/>
            </td>
            <td align="center">
                <h3 style="font-size: 13px;" class="bold">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
                <h3 style="font-size: 13px;" class="bold">REGIMEN DE APLICACIÓN DE SANACIONES ADMINISTRATIVAS (RASA) </h3>
                <h3 style="font-size: 13px;" class="bold">CUADRO UNICO DE INFRACCIONES Y SANCIONES (CUIS) </h3>
            </td>
        </tr>
    </table>
    <br>
    <h5 class="center">NOTIFICACIÓN DE IMPUTACIÓN DE CARGO N° {{$notificacioncargo->numero}}.-MDJLO </h5>
    <p class="center bold">Ordenanza N° {{$notificacioncargo->nro_ordenanza? $notificacioncargo->nro_ordenanza : '-'}}-MDJLO</p>
    <br>
    <table align="right">
        <tr>
            <td class="bold py-5"> Fecha de emisión</td>
            <td class="bordered py-5    bold"> HORA</td>
            <td class="bordered py-5    bold"> DIA</td>
            <td class="bordered py-5    bold"> MES</td>
            <td class="bordered py-5    bold"> AÑO</td>
        </tr>
        <tr>
            <td></td>
            <td class="bordered py-5"> {{date_format(date_create($notificacioncargo->fecha_notificacion ), 'H:i:s')}}</td>
            <td class="bordered py-5"> {{date_format(date_create($notificacioncargo->fecha_notificacion ), 'd')}}</td>
            <td class="bordered py-5">{{date_format(date_create($notificacioncargo->fecha_notificacion ), 'm')}}</td>
            <td class="bordered py-5"> {{date_format(date_create($notificacioncargo->fecha_notificacion ), 'Y')}}</td>
        </tr>
    </table>
    <br>
    <br>
    <br>

    <table width="100%;" border="2" style="border: 2px solid black;">
        <tr>
            <td class="bordered py-5 bold">NOMBRE O RAZÓN SOCIAL DEL INFRACTOR</td>
            <td class="bordered py-5 bold">DNI/RUC/C.I/C.E</td>
        </tr>
        <tr>
            <td class="bordered py-5">{{strtoupper($notificacioncargo->nombre)}}</td>
            <td class="bordered py-5">{{$notificacioncargo->nro_documento}}</td>
        </tr>
    </table>
    <br>

    <table width="100%;" border="2" style="border: 2px solid black;">
        <tr>
            <td colspan="5" class="bordered py-5 bold">DOMICILIO FISCAL DEL PRESUNTO INFRACTOR</td>
        </tr>
        <tr>
            <td class="bordered py-5 bold">CALLE/AV/JR/PSJE</td>
            <td class="bordered py-5 bold">Número</td>
            <td class="bordered py-5 bold">Sector</td>
            <td class="bordered py-5 bold">Mz.</td>
            <td class="bordered py-5 bold">Lt</td>
        </tr> 
        <tr>
            <td class="bordered py-5">{{$notificacioncargo->calle}}</td>
            <td class="bordered py-5">{{$notificacioncargo->nro}}</td>
            <td class="bordered py-5">{{$notificacioncargo->sector}}</td>
            <td class="bordered py-5">{{$notificacioncargo->manzana}}</td>
            <td class="bordered py-5">{{$notificacioncargo->lote}}</td>
        </tr>
        <tr>
            <td class="bordered py-5 bold">URBANIZACIÓN/P.J./AAHH </td>
            <td class="bordered py-5 bold" colspan="4">DISTRITO</td> 
        </tr>
        <tr>
            <td class="bordered py-5">{{$notificacioncargo->urbanizacion}} </td>
            <td class="bordered py-5" colspan="4">{{$notificacioncargo->distrito}}</td> 
        </tr>
    </table>

    <br>

    <table width="100%;" border="2" style="border: 2px solid black;">
        <tr>
            <td colspan="5" class="bordered py-5 bold">LUGAR DE LA INFRACCIÓN</td>
        </tr>
        <tr>
            <td class="bordered py-5 bold">CALLE/AV/JR/PSJE</td>
            <td class="bordered py-5 bold">Número</td>
            <td class="bordered py-5 bold">Sector</td>
            <td class="bordered py-5 bold">Mz.</td>
            <td class="bordered py-5 bold">Lt</td>
        </tr> 
        <tr>
            <td class="bordered py-5">{{$notificacioncargo->i_calle}}</td>
            <td class="bordered py-5">{{$notificacioncargo->i_nro}}</td>
            <td class="bordered py-5">{{$notificacioncargo->i_sector}}</td>
            <td class="bordered py-5">{{$notificacioncargo->i_manzana}}</td>
            <td class="bordered py-5">{{$notificacioncargo->i_lote}}</td>
        </tr>
        <tr>
            <td class="bordered py-5 bold">URBANIZACIÓN/P.J./AAHH </td>
            <td class="bordered py-5 bold" colspan="4">DISTRITO</td> 
        </tr>
        <tr>
            <td class="bordered py-5">{{$notificacioncargo->i_urbanizacion }} </td>
            <td class="bordered py-5" colspan="4">{{$notificacioncargo->i_distrito}}</td> 
        </tr>
    </table>
<br>
    <table width="100%;" border="2" style="border: 2px solid black;">
        <tr>
            <td colspan="4" class="py-5 bold">INFRACCIÓN DETECTADA</td>
        </tr>
        <tr>
            <td class="bordered py-5 bold">Código</td>
            <td class="bordered py-5 bold">Descripción de la infracción</td>
            <td class="bordered py-5 bold">Monto</td>
            <td class="bordered py-5 bold">Medida</td>
        </tr> 
        <tr>
            <td class="bordered py-5">{{ $notificacioncargo->infraccion ? $notificacioncargo->infraccion->codigo : '-' }}</td>
            <td class="bordered py-5 fz-11">{{ $notificacioncargo->infraccion ? $notificacioncargo->infraccion->descripcion : '-' }}</td>
            <td class="bordered py-5">{{ $notificacioncargo->i_monto }}</td>
            <td class="bordered py-5 fz-11">{{ $notificacioncargo->infraccion ? $notificacioncargo->infraccion->medidacomplementaria: '-' }}</td>
        </tr>
        <tr>
            <td class="bordered py-5 bold" colspan="3">DESCRIPCIÓN  DE LOS HECHOS </td>
            <td class="bordered py-5 bold">ACTA FISCALIZACIÓN N°</td>
        </tr> 
        <tr>
            <td class="bordered py-5 fz-11" colspan="3">$notificacioncargo->descripcion</td>
            <td class="bordered py-5 bold" >{{ $notificacioncargo->actafiscalizacion ? $notificacioncargo->actafiscalizacion->numero : '-'}}</td>
        </tr> 
       
    </table>
    <br>
    <p class="py-8 fz-11">a) El infractor tiene 5 (cinco) días de plazo para presentar su descargo en mesa de partes de la Municipalidad
        distrital de José Leonardo Ortiz, si considera que no ha cometido la infracción.</p>
    <p class="py-8 fz-11">
        b) Vencido el plazo, con descargo o sin él, y a mérito de la presente notificación, se emitirá el informe final de
        instrucción y se elevará al Órgano Resolutor para la continuación del Procedimiento Administrativo Sancionador
    </p>
    
</body>

</html>