<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RESOLUCIÓN DE SANCIÓN ADMINISTRATIVA N°: {{ $data->numero }}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/dist/css/adminlte.min.css") }}">
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

    .bold {
        font-weight: bold;
    }

    .center {
        text-align: center;
    }

    .bordered {
        border: 1px solid black;
    }

    .py-5 {
        padding: 0px 5px;
    }

    .py-8 {
        padding: 0px 8px;
    }

    .fz-11 {
        font-size: 11.5px;
    }
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
    overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
    font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-0lax{text-align:left;vertical-align:top}

</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{ asset('imagenes/logo.jpeg') }}" alt="" width="50" />
            </td>
            <td align="center">
                <h3 style="font-size: 1rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
                <h5 style="font-size: .7rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h5>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 class=" font-weight-bold" style="color: black; font-size:1.1rem;">RESOLUCIÓN DE SANCIÓN ADMINISTRATIVA N°
            {{ $data->numero }}-{{ \Carbon\Carbon::now()->year }}-MDJLO/SGF</h1>
    </div>
    <div class=" text-center">
        <h1 class=" font-weight-bold" style="color: black; font-size:.9rem;">Ordenanza Municipal N°
            {{ $data->numero }}-{{ \Carbon\Carbon::now()->year }}-MDJLO</h1>
    </div>
    <br>
    <table class="tabledatos" align="right">
        <tr>
            <td class="bold py-5"> Fecha de emisión</td>
            <td class="bordered py-5    bold"> DIA</td>
            <td class="bordered py-5    bold"> MES</td>
            <td class="bordered py-5    bold"> AÑO</td>
        </tr>
        <tr>
            <td></td>
            <td class="bordered py-5"> {{ date_format(date_create($data->fechaemision), 'd') }}</td>
            <td class="bordered py-5">{{ date_format(date_create($data->fechaemision), 'm') }}</td>
            <td class="bordered py-5"> {{ date_format(date_create($data->fechaemision), 'Y') }}</td>
        </tr>
    </table>
    <br>
    <div>
        <p class=" font-weight-bold" style="font-size: .8rem;">
            <strong>VISTO</strong>
        </p>
        <p style="font-size: .8rem;">
            El Informe Final de Instrucción Nº {{$data->nroinstruccion}} de fecha: {{$data->fechainstruccion}};
        </p>
        <p style="font-size: .8rem;">
            <strong>CONSIDERANDO:</strong>
        </p>
        <p style="font-size: .8rem;">
            Que, mediante notificación de imputación de cargos N° {{ $data->notificacion->numero }} de fecha:
            {{ date_format(date_create($data->notificacion->fecha), 'd/m/Y') }}; se inicia
            el procedimiento administrativo sancionador por la presunta comisión de infracción administrativa,
            conforme se infiere del Acta de Fiscalización N° {{ $data->actafiscalizacion->numero }} de fecha:
            {{ date_format(date_create($data->actafiscalizacion->fecha), 'd/m/Y') }} levantada en
            la diligencia respectiva, que obra en autos a fojas {{ $data->fojas }} dirigida contra:
        </p>
        <table class="tabledatos" width="100%;" border="2" style="border: 2px solid black;">
            <tr>
                <td class="bordered py-5 bold">Nombre y Apellidos o Razón Social:</td>
                <td colspan="4" class="bordered py-5 bold">DNI/RUC</td>
            </tr>
            <tr>
                <td class="bordered py-5">{{ strtoupper($data->notificacion->nombre) }}</td>
                <td colspan="4" class="bordered py-5">{{ $data->notificacion->nro_documento }}</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5 bold">Domicilio Fiscal o Real:</td>
            </tr>
            <tr>
                <td class="bordered py-5 bold">Calle/Av/Jr/Psje</td>
                <td class="bordered py-5 bold">Número</td>
                <td class="bordered py-5 bold">Sector</td>
                <td class="bordered py-5 bold">Mz.</td>
                <td class="bordered py-5 bold">Lt</td>
            </tr>
            <tr>
                <td class="bordered py-5">{{ $data->notificacion->calle }}</td>
                <td class="bordered py-5">{{ $data->notificacion->nro }}</td>
                <td class="bordered py-5">{{ $data->notificacion->sector }}</td>
                <td class="bordered py-5">{{ $data->notificacion->manzana }}</td>
                <td class="bordered py-5">{{ $data->notificacion->lote }}</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5 bold">Giro:</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5">{{ $data->actafiscalizacion->girocomercial }}</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5 bold">Lugar de la Infracción</td>
            </tr>
            <tr>
                <td class="bordered py-5 bold">Calle/Av/Jr/Psje</td>
                <td class="bordered py-5 bold">Número</td>
                <td class="bordered py-5 bold">Sector</td>
                <td class="bordered py-5 bold">Mz.</td>
                <td class="bordered py-5 bold">Lt</td>
            </tr>
            <tr>
                <td class="bordered py-5">{{ $data->notificacion->i_calle }}</td>
                <td class="bordered py-5">{{ $data->notificacion->i_nro }}</td>
                <td class="bordered py-5">{{ $data->notificacion->i_sector }}</td>
                <td class="bordered py-5">{{ $data->notificacion->i_manzana }}</td>
                <td class="bordered py-5">{{ $data->notificacion->i_lote }}</td>
            </tr>
            <tr>
                <td class="bordered py-5 bold">URBANIZACIÓN/P.J./AAHH </td>
                <td class="bordered py-5 bold" colspan="4">DISTRITO</td>
            </tr>
            <tr>
                <td class="bordered py-5">{{ $data->notificacion->i_urbanizacion }} </td>
                <td class="bordered py-5" colspan="4">{{ $data->notificacion->i_distrito }}</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5 bold">Código de Infracción:</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5">{{ $data->notificacion->infraccion->codigo }}</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5 bold">Descripción de la Infracción::</td>
            </tr>
            <tr>
                <td colspan="5" class="bordered py-5">{{ $data->notificacion->infraccion->descripcion }}</td>
            </tr>
        </table>
        <br>
        <p style="font-size: .8rem;">
            Que, dentro del plazo previsto en el artículo 33° de la Ordenanza N° {{ $data->ordenanza }}-2021-MDJLO
            Reglamento de
            Aplicación de Sanciones Administrativas, el infractor formula descargo
            expresando que :
        </p>
        <p style="font-size: .8rem;">
            {{ $data->descargo }}
        </p>
        <p style="font-size: .8rem;">
            Que, evaluado el informe final de instrucción, así como todos los actuados que forman parte del
            presente procedimiento sancionador, esta Sub Gerencia, ha llegado a determinar lo siguiente:
        </p>
        <p style="font-size: .8rem;">
            {{ $data->conclusion }}
        </p>
        <p style="font-size: .8rem;">
            Que, por ello, en atención a lo previsto en la citada Ordenanza, es aplicable la sanción administrativa de
            <strong>MULTA</strong> comunicada en la notificación de imputación de cargos, además de la medida accesoria
            respectiva.
        </p>
        <p style="font-size: .8rem;">
            En uso de las atribuciones previstas en la Ordenanza N° {{ $data->ordenanza }}-2021-MDJLO y del TUO de la
            Ley del
            Procedimiento Administrativo General, Ley N° 27444;
        </p>
        <p style="font-size: .8rem;">
            <strong>RESUELVE:</strong>
        </p>
        <p style="font-size: .8rem;">
            <strong>Artículo 1°.- IMPONER</strong> la sanción de <strong>MULTA</strong> a
            {{ strtoupper($data->notificacion->nombre) }}
            titular del local comercial ubicado en {{ $data->actafiscalizacion->direccion }},
            jurisdicción de este distrito; por la infracción, que se detalla a continuación:
        </p>
        <table class="tg tabledatos" width="100%;" border="2" style="border: 2px solid black;">
            <thead>
              <tr>
                <th class="tg-0lax bordered py-5 bold" rowspan="2"><strong>CÓDIGO</strong></th>
                <th class="tg-0lax bordered py-5 bold" rowspan="2"><strong>DESCRIPCION DE INFRACCIÓN</strong></th>
                <th class="tg-0lax bordered py-5 bold" colspan="2"><strong>MULTA IMPUESTA</strong></th>
              </tr>
              <tr>
                <td class="tg-0lax bordered py-5 bold">%UIT</td>
                <td class="tg-0lax bordered py-5 bold">S/</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="tg-0lax bordered py-5">{{$data->notificacion->infraccion->codigo}}</td>
                <td class="tg-0lax bordered py-5 fz-11">{{$data->notificacion->infraccion->descripcion }}</td>
                <td class="tg-0lax bordered py-5">{{'-'}}</td>
                <td class="tg-0lax bordered py-5">{{$data->notificacion->i_monto}}</td>
              </tr>
              <tr>
                <td class="tg-0lax"></td>
                <td class="tg-0lax"></td>
                <td class="tg-0lax bordered py-5 bold">TOTAL</td>
                <td class="tg-0lax bordered py-5 bold">S/. {{$data->notificacion->i_monto}}</td>
              </tr>
            </tbody>
        </table>
        <br>
        <p style="font-size: .8rem;">
            <strong>SON: {{$enletras}}</strong> 
        </p>
        <p style="font-size: .8rem;">
            <strong>Artículo 2°.- IMPONER</strong> la medida correctiva de {{ $data->medidacorrectiva }} al
            establecimiento descrito en
            el artículo anterior por el período de {{ $data->periodo }} días.
        </p>
        <p style="font-size: .8rem;">
            <strong>Artículo 3°.- SE OTROGA</strong> al administrado el plazo de <strong>QUINCE DÍAS HÁBILES</strong>
            contados a
            partir de la notificación con la presente Resolución, para que cumpla con cancelar a favor de la
            Municipalidad distrital de José Leonardo Ortiz, el total del monto de la multa impuesta,
            y vencido dicho plazo o <strong>CONSENTIDA</strong> la misma, se dispone su remisión a la Oficina de
            Ejecución Coactiva del Servicio de Administración Tributaria – SAT, para que inicie el
            Procedimiento Coactivo conforme a ley.
        </p>
        <p style="font-size: .8rem;">
            <strong>Artículo 4°.-</strong> El administrado puede acogerse a las facilidades para el
            pago de la multa previstos en el artículo 52 de la Ordenanza {{ $data->ordenanza }}-2021-MDJLO
        </p>
        <p style="font-size: .8rem;">
            <strong>Artículo 5°.-</strong> La presente Resolución no agota la vía administrativa,
            dejando a salvo su derecho de interponer los recursos impugnativos establecidos en la Ley N° 27444,
            Ley del Procedimiento Administrativo General.
        </p>
    </div>
    <br>
    <br>
    <div class=" float-right">
        __________________________________________
    </div>
    <br>
    <br>
    <div style="font-size: .8rem;" class=" float-right">
        <strong>FIRMA DEL ÓRGANO RESOLUTOR</strong> <span style="color: white">AAAAAAAA</span>
    </div>

</body>

</html>
