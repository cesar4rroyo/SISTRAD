<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte resolucion</title>
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
            <th colspan="7" style="text-align: center"><b>REPORTE DE RESOLUCIONES DESDE {{ date_format(date_create($fecinicio),  'd/m/Y') }} HASTA {{ date_format(date_create($fecfin),  'd/m/Y') }} </b></th>
        </tr>
        <tr>
            <th><b>FECHA EXPEDICION</b></th>
            <th><b>FECHA VENCIMIENTO</b></th>                
            <th><b>NÚMERO</b></th>
            <th><b>TRAMITE REF.</b></th>
            <th><b>TIPO</b></th>
            <th><b>SUBTIPO</b></th>
            <th><b>CONTIBUYENTE</b></th>
        </tr>
        </thead>
        <tbody>
        @php
            $total=0;
        @endphp
        @foreach($lista1 as $key => $value)
            <tr>
                <td class="padding-left">{{ date_format(date_create($value->fechaexpedicion),  'd/m/Y') }}</td>
                <td class="padding-left">{{  date_format(date_create($value->fechavencimiento),  'd/m/Y')}}</td>
                <td class="padding-left">{{ $value->numero }}</td>
                <td class="padding-left">{{ $value->tramite->numero }}</td>
                <td class="padding-left">{{ $value->tipotramite->descripcion }}</td>
                <td class="padding-left">{{ $value->subtipo->descripcion }}</td>
                <td class="padding-left">{{ ($value->contribuyente) ? $value->contribuyente : $value->razonsocial }}</td>
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