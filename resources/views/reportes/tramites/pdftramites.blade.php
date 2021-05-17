<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte trámites</title>
</head>
<style>
    body {
        font-family: 'Courier New', Courier, monospace;
    }
    table , table tr , table tr td , table th{
        border: 1px solid black;
    }
    table {
        border-collapse: collapse;
    }
    body{
        font-size: 14.5px;
    }
    table {
        margin-left: 10px;
        margin-right: 10px;
    }
    .align-center {
        text-align: center;
    }

    .padding-left{
        padding : 0px 3px;
    }
        
</style>
<body>
    @if (count($lista1)>0)
    <table>
        <thead>
        <tr>
            <th colspan="9" style="text-align: center"><b>REPORTE DE TRÁMITES DESDE {{ date_format(date_create($fecinicio),  'd/m/Y') }} HASTA {{ date_format(date_create($fecfin),  'd/m/Y') }} </b></th>
        </tr>
        <tr>
            <th><b>FECHA</b></th>
            <th><b>NÚMERO</b></th>
            <th><b>TIPO</b></th>
            <th><b>PROC.</b></th>
            <th><b>ASUNTO</b></th>
            <th><b>REMITENTE</b></th>
            <th><b>A.ORIGEN</b></th>
            <th><b>A.ACTUAL</b></th>
            <th><b>SITUACION</b></th>
        </tr>
        </thead>
        <tbody>
        @php
            $total=0;
        @endphp
        @foreach($lista1 as $key => $value)
            <tr>
                <td class="padding-left">{{ date_format(date_create($value->fecha),  'd/m/Y') }}</td>
                <td class="padding-left">{{ $value->numero }}</td>
                <td class="padding-left">{{ $value->tipo }}</td>
                <td class="padding-left">{{ $value->tipo == 'TUPA' ? $value->procedimiento->descripcion : '' }}</td>
                <td class="padding-left">{{ $value->asunto }}</td>
                <td class="padding-left">{{ $value->remitente }}</td>
                <td class="padding-left">{{ $value->firstSeguimiento->area }}</td>
                <td class="padding-left">{{ $value->latestSeguimiento->area }}</td>
                <td class="padding-left">{{ $value->situacion }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <table>
        <tr>
            <td>
                SIN RESULTADOS
            </td>
        </tr>
    </table>
@endif
</body>
</html>