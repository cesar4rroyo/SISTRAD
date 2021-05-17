<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte pagos</title>
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
        width: 90%;
    }
    body{
        font-size: 16px;
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

    .bg-warning {
        background: rgb(218, 235, 66)
    }
    .bg-success{
        background: rgb(19, 235, 19);
    }
        
</style>
<body>
    @if (count($lista1)>0)
    <table>
        <thead>
        <tr>
            <th colspan="7" style="text-align: center"><b>REPORTE DE PAGOS DESDE {{ date_format(date_create($fecinicio),  'd/m/Y') }} HASTA {{ date_format(date_create($fecfin),  'd/m/Y') }} </b></th>
        </tr>
        <tr>
            <th><b>FECHA</b></th>
            <th><b>NÚMERO</b></th>
            <th><b>TIPO</b></th>
            <th><b>SUBTIPO</b></th>
            <th><b>DNI/RUC</b></th>
            <th><b>ESTADO</b></th>
            <th><b>MONTO</b></th>
        </tr>
        </thead>
        <tbody>
        @php
            $total=0;
        @endphp
        @foreach($lista1 as $key => $value)
            @php
                $total += $value->monto;
            @endphp
            <tr>
                <td class="padding-left">{{ date_format(date_create($value->fecha),  'd/m/Y') }}</td>
                <td class="padding-left">{{ $value->numero }}</td>
                <td class="padding-left">{{ $value->tipotramite->descripcion }}</td>
                <td class="padding-left">{{ $value->subtipotramite ? $value->subtipotramite->descripcion : '-' }}</td>
                <td class="padding-left">{{ $value->dni_ruc }}</td>
                <td class="padding-left {{$value->estado == 'pendiente' ? 'bg-warning':'bg-success'}}"  >{{ strtoupper($value->estado) }}</td>
                <td class="padding-left">{{ $value->monto }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6"></td>
                <td >{{$total}}</td>
            </tr>
        </tfoot>
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