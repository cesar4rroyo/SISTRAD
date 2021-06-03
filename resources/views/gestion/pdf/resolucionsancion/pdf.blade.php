<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RESOLUCIÓN DE SANCIÓN ADMINISTRATIVA N°: {{$data->numero}}</title>
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
                <img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="50"/>
            </td>
            <td align="center">
                <h3 style="font-size: 1rem;">MUNICIPALIDAD DISTRITAL DE JOSE LEONARDO ORTIZ</h3>
                <h5 style="font-size: .7rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h5>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="color: black; font-size:1rem; text-decoration: underline;">RESOLUCIÓN DE SANCIÓN ADMINISTRATIVA N° {{$data->numero}}-{{\Carbon\Carbon::now()->year}}-MDJLO/SGF</h1>
    </div>
    <p style="color: black; font-size:.8rem;" class=" float-right">
        {{ date_format(date_create($data->fechaemision ), 'd/m/Y')}}
    </p>
    <br>
    <div>
        <p style="font-size: .8rem;">
            <strong>VISTO</strong>
        </p>
        <p style="font-size: .8rem;">
            El Informe Final de Instrucción Nº ....... de fecha: ..........;            
        </p>
        <p style="font-size: .8rem;">
            <strong>CONSIDERANDO:</strong>
        </p>
        <p style="font-size: .8rem;">
            Que, mediante notificación de imputación de cargos N° ##### de fecha: {{date_format(date_create($data->notificacion->fecha), 'd/m/Y')}}; se inicia 
            el procedimiento administrativo sancionador por la presunta comisión de infracción administrativa, 
            conforme se infiere del Acta de Fiscalización N° {{$data->actafiscalizacion->numero}} de fecha: {{date_format(date_create($data->actafiscalizacion->fecha), 'd/m/Y')}} levantada en 
            la diligencia respectiva, que obra en autos a fojas........ dirigida contra:           
        </p>
        <p style="font-size: .8rem;">
            Que, dentro del plazo previsto en el artículo 33° de la Ordenanza N° {{$data->ordenanza}}-2021-MDJLO Reglamento de 
            Aplicación de Sanciones Administrativas, el infractor formula descargo 
            expresando que :            
        </p>
        <p style="font-size: .8rem;">
            {{$data->descargo}}
        </p>
        <p style="font-size: .8rem;">
            Que, evaluado el informe final de instrucción, así como todos los actuados que forman parte del 
            presente procedimiento sancionador, esta Sub Gerencia, ha llegado a determinar lo siguiente:
        </p>
        <p style="font-size: .8rem;">
            {{$data->conclusion}}
        </p>
        <p style="font-size: .8rem;">
            Que, por ello, en atención a lo previsto en la citada Ordenanza, es aplicable la sanción administrativa de
             <strong>MULTA</strong> comunicada en la notificación de imputación de cargos, además de la medida accesoria respectiva.
        </p>




    </div>
    <div class="ml-5">
        
    </div>   
    <br>
    <div class="text-general">
        <strong>BASE LEGAL:</strong> <br>
        Ley N° 27444 - (Ley del Procedimiento Administrativo) <br>
        Ley N° 27972 - (Ley Orgánicas de Municipalidades) <br>
        Ley N° 28976 - (Ley Marco de Licencia de Funcionamiento) <br>
    </div>
    <br>
    
</body>

</html>