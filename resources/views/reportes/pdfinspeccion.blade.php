<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Inspección</title>
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
            <th colspan="{{($has_observacion) ? 8 : 7}}" style="text-align: center"><b>REPORTE DE INSPECCIONES DESDE {{ date_format(date_create($fecinicio),  'd/m/Y') }} HASTA {{ date_format(date_create($fecfin),  'd/m/Y') }} </b></th>
        </tr>
        <tr>
            <th><b>FECHA SOLICITUD</b></th>
            @if ($has_observacion)
                <th><b>FECHA LIMITE</b></th>                
            @endif
            <th><b>NÚMERO</b></th>
            <th><b>ESTADO</b></th>
            <th><b>TIPO</b></th>
            <th><b>REPRESENTANTE</b></th>
            <th><b>RAZON SOCIAL</b></th>
            <th><b>INSPECTOR</b></th>
        </tr>
        </thead>
        <tbody>
        @php
            $total=0;
        @endphp
        @foreach($lista1 as $key => $value)
            <tr>
                <td class="padding-left">{{ date_format(date_create($value->fecha),  'd/m/Y') }}</td>
                @if ($has_observacion)
                    <td class="padding-left">{{(count($value->carta)>=1) ? (date_format(date_create($value->carta[count($value->carta)-1]),  'd/m/Y')) : 'PENDIENTE' }}</td>
                @endif
                <td class="padding-left">{{ $value->numero }}</td>
                <td class="padding-left">{{ $value->estado }}</td>
                <td class="padding-left">{{ $value->tipotramite->descripcion }}</td>
                <td class="padding-left">{{ ($value->representante) ? $value->representante : '-' }}</td>
                <td class="padding-left">{{ ($value->razonsocial) ? $value->razonsocial : '-'  }}</td>
                <td class="padding-left">{{ $value->inspector->apellidopaterno . ' ' . $value->inspector->apellidomaterno . ' ' . $value->inspector->nombres }}</td>
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