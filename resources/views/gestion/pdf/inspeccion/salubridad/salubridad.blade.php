<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Acta de Inspeccion de Salubridad: {{$data->numero}}</title>
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
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="30"/>
            </td>
            <td align="center">
                <h3 style="font-size: .8rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="color: black; font-size:1rem; text-decoration: underline;">ACTA DE INSPECCION N° {{$data->numero}}-2021-MDJLO/SGPSyS</h1>
    </div>
    <div>
        <p style="font-size: .8rem; text-indent:18px">
            En la localidad de José Leonardo Ortiz, se procede a suscribir la presente como resultado
            de la inspección ocular realizada, a efectos de evaluar IN SITU las condiciones higiénico sanitarias, 
            así como las medidas de seguridad y prevención ambiental implementadas acorde con las actividades propias
            del local inspeccionado, razón por que detalla las generales de ley para fines de identificación.
        </p>
    </div>
    <div class="ml-5">
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>TIPO DE ACTIVIDAD: </strong>
                </td>
                <td>
                    {{$data->girocomercial}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>RAZON SOCIAL: </strong>
                </td>
                <td>
                    {{$data->razonsocial}}
                </td>
                <td>
                    <strong>RUC N°</strong>
                    <td>
                        {{$data->ruc}}
                    </td>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>REPRESENTANTE </strong>
                </td>
                <td>
                    {{$data->representante}}
                </td>
                <td>
                    <strong>DNI N°</strong>
                    <td>
                        {{$data->dni}}
                    </td>
                </td>
            </tr>
        </table>
    </div>   
    <br>
    <div class="text-general">
        <strong>BASE LEGAL:</strong> <br>
        Ley N° 26842 - Ley General de Salud <br>
        Ley N° 27557 - Ley del Ministerio de Salud <br>
        Decreto Legislativo 1062 - Ley de Inocuidad de los Alimentos - D.S. 034-2008-AG <br>
        Ley N° 29571 : Código de Protección y Defensa del Consumidor <br>
        Ley N° 27444 - Ley del Procedimiento Administrativo <br>
    </div>
    <br>
    <br>
    <div class="text-general">
        <strong>DESCRIPCION DEL LOCAL</strong> <br>
        <p>
            {{$data->descripcion}}
        </p>
    </div>
    <br>
    <br>
    <div class="text-general">
        <strong>OBSERVACIONES/RECOMENDACIONES</strong> <br>
        <p>
            {{$data->observacion}}
        </p>
    </div>
    <br>
    <br>
    <div class="text-general">
        <strong>CONCLUSIONES</strong> <br>
        <p>
            {{$data->conclusiones}}
        </p>
    </div> 
</body>

</html>