<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de pago</title>
</head>
<style>
  

    .titulo {
        text-decoration: underline;
    }

    table {
        border-collapse: collapse;
        width: 90%;
    }
    table, tr , td {
        border: 1px solid black;

    }

    table tr td {
        padding: 5px;
    }

    
    .b{
        font-weight: bold;
    }
    .center {
        text-align: center;
    }

    
     td.b {
         width: 150px;
     }

</style>
<body>
        <h3 class="titulo">LIQUIDACIÓN DE PAGO</h3>
        <br>
        <table>
            <tbody>
                <tr>
                    <td class="b" >CÓDIGO PAGO</td>
                    <td >{{$ordenpago->codigopago}}</td>
                    <td class="b" >CORRELATIVO</td>
                    <td >{{$ordenpago->numero}}</td>
                </tr>
                <tr>
                    <td class="b" >FECHA</td>
                    <td colspan="3">{{date_format(date_create($ordenpago->fecha) ,'d/m/Y')}}</td>
                </tr>
                <tr>
                    <td class="b" >AREA</td>
                    <td colspan="3">{{$ordenpago->tipotramite->descripcion}}</td>
                </tr>
                <tr>
                    <td class="b" >SUBTIPO</td>
                    <td colspan="3">{{ $ordenpago->subtipotramite ? $ordenpago->subtipotramite->descripcion : '-' }}</td>
                </tr>
                <tr class="height150">
                    <td class="b"  >DESCRIPCIÓN</td>
                    <td colspan="3"> {{$ordenpago->descripcion}}</td>
                </tr>
                <tr>
                    <td class="b" >CONTRIBUYENTE</td>
                    <td colspan="3">{{$ordenpago->contribuyente}}</td>
                </tr>
                <tr>
                    <td class="b" >DIRECCION</td>
                    <td colspan="3">{{$ordenpago->direccion}}</td>
                </tr>
                <tr>
                    <td class="b" >MONTO</td>
                    <td colspan="3">{{number_format($ordenpago->monto ,2)}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr >
                    <td colspan="4"><b>Son:</b> {{$enletras}}</td>
                </tr>
            </tfoot>
        </table>
</body>
</html>