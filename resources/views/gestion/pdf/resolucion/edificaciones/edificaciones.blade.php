<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resolucion de Licencia de Edificación: {{$data->numero}}</title>
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
        font-size: .9rem;
    }
    .text-general {
        font-size: .9rem;
    }
    .centerTable{
        text-align: center;
    }
    .centerTable table{
        margin: 0 auto;
        text-align: left;
    }
</style>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="50"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" float-right" style="font-size: .7rem; line-height:3%">
        <p class=" font-weight-bold">EXPEDIENTE NRO. {{$data->tramite->numero}}</p>
        <p class=" font-weight-bold">FECHA DE EMISION. {{$data->fechaexpedicion}}</p>
        <p class=" font-weight-bold">FECHA DE VENCIMIENTO. {{$data->fechavencimiento}}</p>
    </div>
    <br>
    <br>
    <br>
    <div class=" text-center">
        <h1 style="color: black; font-size:1.2rem; text-decoration: underline;">RESOLUCIÓN DE LICENCIA DE EDIFICACIÓN N° {{$data->numero}}-2021-MDJLO/GIDU/SGHUyEP</h1>
    </div>
    <br>
    <div class="text-center">
        <h1 style="color: black; font-size:1rem; text-decoration: none;">PROYECTO: {{$data->proyecto}}</h1>
    </div>
    <br>
    <div class="">     
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>USO:</strong>
                </td>
                <td>
                    {{$data->uso}}
                </td>             
            </tr> 
            <tr>
                <td>
                    <strong>ZONIFICACIÓN:</strong>
                </td>
                <td>
                    {{$data->zona}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ALTURA:</strong>
                </td>
                <td>
                    {{$data->altura}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>PROPIETARIO:</strong>
                </td>
                <td>
                    {{$data->contribuyente}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>UBICACIÓN:</strong>
                </td>
                <td>
                    {{$data->direccion}}
                </td>
            </tr>
            </table>
            <table class="tabledatos">
                <tr>
                    <td>
                        <strong>AREA CONSTRUIDA(M2):</strong>
                    </td>
                </tr>
            </table>
               <div class="text-center" style="font-size: .9rem">
                1 PISO = {{$data2[0]}} M2 <br>
                @if ($data2[1]!=0)
                    2 PISO = {{$data2[1]}} M2 <br>
                @endif
                @if ($data2[2]!=0)
                    3 PISO = {{$data2[2]}} M2 <br>
                @endif
                @if ($data2[3]!=0)
                    4 PISO = {{$data2[2]}} M2 <br>
                @endif
                @if ($data2[3]!=0)
                    AZOTEA = {{$data2[4]}} M2 <br>
                @endif
                ------------------------------- <br>
                TOTAL= {{$data->area}}
               </div>
           <table class="tabledatos">
            <tr>
                <td>
                    <strong>VALOR DE LA OBRA:</strong>
                </td>
                <td>
                    {{$data->valor . ' ' . 'SOLES'}} 
                </td>
            </tr>
            <tr>
                <td>
                    <strong>RESPONSABLE DE LA OBRA:</strong>
                </td>
                <td>
                    {{$data->responsableobra}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>DERECHO DE PAGO:</strong>
                </td>
                <td>
                    {{$data->ordenpago->monto . ' ' . 'SOLES'}} 
                </td>
            </tr>
            <tr>
                <td>
                    <strong>RECIBO NRO:</strong>
                </td>
                <td>
                    {{$data->ordenpago->numerooperacion}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>OBSERVACIONES</strong>
                </td>                
            </tr>
        </table>
    </div>
    <div>
        <p style="font-size: .8rem; text-indent:18px">
            {{$data->observaciones}}

        </p>
    </div>    
</body>

</html>
