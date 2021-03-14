<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trámite Nro: {{$data->numero}}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
</head>
<style>
    .table {
        width: 100%;
    }
</style>

<body>
    <div>
        <p class="font-weight-bold">Seguimiento del trámite Nro: {{$data->numero}}</p>
        <p class=" float-right">Fecha: {{\Carbon\Carbon::now()}}</p>
        <table class="table text-center mt-5">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Operación</th>
                    <th>Responsable</th>
                    <th>Area Origen</th>
                    <th>Area Destino </th>
                    <th>Observación</th>
                    <th>Archivos Adjuntos(link)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->seguimientos as $item)
                <tr>
                    <td>{{$item->fecha}}</td>
                    <td>
                        <span class="badge {{($item->accion=='RECHAZAR')?'badge-danger':(($item->accion=='FINALIZAR')?'badge-success':(($item->accion=='ADJUNTAR')?'badge-warning':'badge-info'))}}">
                            {{$item->accion}}
                        </span>
                    </td>
                    <td>
                        {{$item->personal->nombres . ' ' .$item->personal->apellidopaterno .' ' . $item->personal->apellidomaterno}}
                    </td>
                    <td>
                        {{ $item->area }}
                    </td>
                    <td>
                        {{($item->areas) ? $item->areas->descripcion : $item->area }}
                    </td>
                    <td>{{$item->observacion}}</td>
                    <td>
                       {{$item->ruta ? $item->ruta : '-'}}
                    </td>
                </tr>                
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>