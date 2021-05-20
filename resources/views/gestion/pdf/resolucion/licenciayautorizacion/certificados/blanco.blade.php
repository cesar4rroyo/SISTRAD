<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resolucion Salubridad Nro: {{$data->numero}}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
</head>
<style type="text/css">
   .contribuyente{
       position: absolute;
       top:9cm;
       left: 6.5cm;
   }
   .razonsocial{
        position: absolute;
        top:10cm;
        left: 6.5cm;
   }
   .girocomercial{
       position: absolute;
       top:12cm;
       left: 6.5cm;
   }

   .calle{
       position: absolute;
       top:14cm;
       left: 6.5cm;
   }
   .nro{
       position: absolute;
       top:14cm;
       left: 15cm;
   }
   .urb{
       position: absolute;
       top:14cm;
       left: 21cm;
   }

   .fecha{
        position: absolute;
        top: 2.5cm;
        left: 4.5cm;
   }
   .resolucion{
        position: absolute;
        top: 2.5cm;
        left: 13cm;
   }
   .expediente{
        position: absolute;
        top: 4cm;
        left: 4.5cm;
   }
   .area{
        position: absolute;
        top: 4cm;
        left: 15cm;
   }
</style>
<body>
    <div class="fecha">{{ date_format(date_create($data->tramite->fecha ), 'd/m/Y')}}</div>
    <div class="resolucion">{{$data->numero}}/GDEyS<span style="color: white">AAAAA</span> {{date_format(date_create($data->fechaexpedicion ), 'd/m/Y')}} <span style="color: white">AAAAAAA</span>{{$data->nrocertificado}} </div>
    <div class="expediente">{{$data->tramite->numero}}</div>
    <div class="area">
        {{$data->area . ' M2'}}
        <span style="color: white">AAAAAAA</span>
        @if ($data->tipopersona=='P/NAT')
        {{'X'}}
        @else
            <span>AAAAAAA</span>{{' X'}}
        @endif
    </div>
    <div class="contribuyente">
        {{$data->contribuyente}}
    </div>
    <div class="razonsocial">
        {{$data->razonsocial}}
    </div>
    <div class="girocomercial">
        {{$data->girocomercial}}
    </div>
    <div class="calle">
        {{$direccion[0]}}
    </div>
    <div class="nro">
        {{$direccion[1]}}
    </div>
    <div class="urb">
        {{$direccion[2]}}
    </div>
</body>

</html>