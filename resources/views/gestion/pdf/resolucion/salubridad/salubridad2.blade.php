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
   .direccion{
        position: absolute;
        top:10cm;
        left: 6.5cm;
   }
   .localidad{
       position: absolute;
       top:11cm;
       left: 6.5cm;
   }
   .numero{
        position: absolute;
        top:12cm;
        left: 6.5cm;
   }
   .categoria{
       position: absolute;
       top:12cm;
       left: 10cm;
   }
   .zona{
        position: absolute;
        top:12cm;
        left: 13cm;
   }
   .razonsocial{
       position: absolute;
       top:13.5cm;
       left: 6.5cm;
   }
   .girocomercial{
        position: absolute;
        top:14.5cm;
        left: 6.5cm;
   }
   .fechaexpedicion{
       position: absolute;
       top:16cm;
       left: 10cm;
   }
   .fechavencimiento{
        position: absolute;
        top:17cm;
        left: 10cm;
   }
   
    
</style>

<body>
    <div class="contribuyente">
        {{$data->contribuyente}}
    </div>
    <div class="direccion">
        {{$data->direccion}}
    </div>
    <div class="localidad">
        {{$data->localidad}}
    </div>
    <div class="numero">
        {{$data->numero}}
    </div>
    <div class="categoria">
        {{$data->categoria}}
    </div>
    <div class="zona">
    {{$data->zona}}
    </div>
    <div class="razonsocial">
        {{$data->razonsocial}}
    </div>
    <div class="girocomercial">
        {{$data->girocomercial}}
    </div>
    <div class="fechaexpedicion">
        {{ date_format(date_create($data->fechaexpedicion ), 'd/m/Y')}}
    </div>
    <div class="fechavencimiento">
        {{date_format(date_create($data->fechavencimiento) ,'d/m/Y')}}
    </div>
</body>

</html>