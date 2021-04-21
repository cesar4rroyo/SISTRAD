<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trámite N°: {{$data->numero}}</title>
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
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="20"/>
            </td>
            <td align="center">
                <h3 style="font-size: .8rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="color: black; font-size:0.9rem; text-decoration: underline;">TRÁMITE N° {{$data->numero}}-MDJLO</h1>
    </div>
    <div class>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>FECHA: </strong>
                </td>
                <td>
                    {{$data->fecha}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>PRIORIDAD: </strong>                    
                </td>
                <td>
                    {{$data->prioridad}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ASUNTO: </strong>
                </td>
                <td>
                    {{$data->asunto}}
                </td>               
            </tr>
            <tr>
                <td>
                    <strong>REMITENTE: </strong>
                    <td>
                        {{$data->remitente}}
                    </td>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>TIPO DE DOCUMENTO: </strong>
                    <td>
                        {{$data->tipodocumento->descripcion}}
                    </td>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>TIPO DE PROCEDIMIENTO: </strong>
                </td>
                @if ($data->tipo == 'INTERNO')
                    <td>
                        {{"PROCEDIMIENTO INTERNO"}}
                    </td>
                @else
                    <td>
                        {{$data->procedimiento->descripcion}}
                    </td>
                @endif                
            </tr> 
            <tr>
                <td>
                    <strong>FOLIOS: </strong>                    
                </td>
                <td>
                    {{$data->folios}}
                </td>
            </tr>           
        </table>        
    </div>   
</body>

</html>