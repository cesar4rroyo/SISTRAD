@if ($pretramite)
<style>
    .bg-error{
        background: rgb(223, 107, 107);
        color: white;
    }
</style>
<table class="table table-bordered my-3">
    <thead>
        <tr>
            <th>Fecha/hora</th>
            <th>Accion</th>
            <th>Comentario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$pretramite->created_at}}</td>
            <td>REGISTRADO EN LA PLATAFORMA VIRTUAL</td>
            <td>-</td>
            <td>-</td>
        </tr>

        @if($pretramite->fecha_rechazado)
            <tr>
                <td>{{$pretramite->fecha_rechazado}}</td>
                <td class="bg-error">RECHAZADO</td>
                <td>{{$pretramite->motivo_rechazo}}</td>
                <td>-</td>
            </tr>
        @elseif($pretramite->fecha_aceptado)
            <tr>
                <td>{{$pretramite->fecha_aceptado}}</td>
                <td>ACEPTADO</td>
                <td>{{$pretramite->motivo_aceptado}}</td>
                <td>-</td>
            </tr>
        @endif

        @if($pretramite->fecha_creado)
            <tr>
                <td>{{$pretramite->fecha_creado}}</td>
                <td>TRÁMITE CREADO</td>
                <td>-</td>
                <td><button class="btn btn-primary" onclick="imprimirpdf({{$tramite->id}})"><i class="fa fa-route"> Ver proceso</i></button></td>
            </tr>
        @endif
    </tbody>
</table>
@elseif($tipo == 'presencial' && $tramite)

<table class="table table-bordered my-3">
    <thead>
        <tr>
            <th>Fecha/hora</th>
            <th>Número</th>
            <th>Remitente</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$tramite->fecha}}</td>
            <td>REGISTRADO MODALIDAD PRESENCIAL</td>
            <td>{{$tramite->remitente}}</td>
            <td><button class="btn btn-primary" onclick="imprimirpdf({{$tramite->id}})"><i class="fa fa-route"> Ver proceso</i></button></td>
        </tr>
    </tbody>
</table>
@else
<div class="alert alert-warning" role="alert">
    Ninguno de nuestros registros coincide con los datos proporcionados.
  </div>
@endif
<script>
    function imprimirpdf(id){
            window.open("tramitevirtual/seguimiento/pdf/"+id,"_blank");
        }
</script>

