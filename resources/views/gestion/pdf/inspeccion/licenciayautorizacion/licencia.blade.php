<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Acta de Inspeccion de Licencia y Autorizacion: {{$data->numero}}</title>
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
                <h4 style="font-size: .8rem">OFICINA DE LICENCIAS Y AUTORIZACIONES</h4>
                <h5 style="font-size: .7rem">PALACIO MUNICIPAL. AV. SAENZ PEÑA N° 2151 - URB. LATINA</h5>
            </td>
        </tr>
    </table>
    <hr>
    <div class=" text-center">
        <h1 style="color: black; font-size:1rem; text-decoration: underline;">ACTA DE INSPECCION N° {{$data->numero}}-{{\Carbon\Carbon::now()->year}}-MDJLO-OLyA/M.O.D.C.</h1>
    </div>
    <div>
        <p style="font-size: .8rem; text-indent:18px">
            En la localidad de José Leonardo Ortiz, se procede a suscribir la presente como resultado
            de la <strong>INSPECCION OCULAR</strong> realizada a efectos de evaluar <strong>IN SITU</strong>, de las
            características del Establecimiento / Negocio (metraje, todo tipo de Anuncios Publicitarios, Fachadas tanto Simple
            y Luminoso, así como Paneles Electrónicos, Gigantografías, acorde con las actividades propias del Local inspeccionado,
             razón por la que se detalla las generales de la ley de identificación.</p>
    </div>
    <div class="ml-5">
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>TIPO DE ACTIVIDAD: </strong>
                </td>
                <td>
                    {{$data->girocomercial}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>RAZON SOCIAL: </strong>
                </td>
                <td>
                    {{$data->razonsocial}}
                </td>
                <td>
                    <strong>RUC N°</strong>
                    <td>
                        {{$data->ruc}}
                    </td>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>REPRESENTANTE </strong>
                </td>
                <td>
                    {{$data->representante}}
                </td>
                <td>
                    <strong>DNI N°</strong>
                    <td>
                        {{$data->dni}}
                    </td>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>DIRECCION</strong>
                </td>
                <td>
                    {{$data->direccion}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>LOCALIDAD(URB. PJ)</strong>
                </td>
                <td>
                    {{$data->localidad}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>ÁREA DEL ESTABLECIMIENTO</strong>
                </td>
                <td>
                    {{$data->area}}
                </td>
            </tr>
        </table>
    </div>   
    <br>
    <div class="text-general">
        <strong>BASE LEGAL:</strong> <br>
        Ley N° 27444 - (Ley del Procedimiento Administrativo) <br>
        Ley N° 27972 - (Ley Orgánicas de Municipalidades) <br>
        Ley N° 28976 - (Ley Marco de Licencia de Funcionamiento) <br>
    </div>
    <br>
    <div class="text-general">
        <strong>DESCRIPCION DEL LOCAL</strong> <br>
        <p>
            {{$data->descripcion}}
        </p>
    </div>
    <br>
    <div class="text-general">
        <strong>OBSERVACIONES/RECOMENDACIONES</strong> <br>
        <p>
            {{$data->observacion}}
        </p>
    </div>
    <br>
    <div class="text-general">
        <strong>CONCLUSIONES</strong> <br>
        <p>
            {{$data->conclusiones}}
        </p>
    </div>
    <p style="font-size: .8rem; text-indent:18px">
        Siendo {{ date_format(date_create($data->fecha ), 'd/m/Y')}}, se da por concluido dicho acto y en fe de conformidad y de veracidad de lo actuado
    se procede a firmar y estampar su huella dactilar</p>
    <br>
    <div class="ml-5">
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>REPRESENTANTE: </strong>
                </td>
                <td>
                    {{$data->representante}}
                </td>
                <td>
                    <strong>FIRMA DEL REPRESENTANTE: </strong>
                </td>
                <td>
                    {{''}}
                </td>  
            </tr>
            <tr>
                <td>
                    <strong></strong>
                </td>
                <td>
                    DNI N° {{$data->dni}}
                </td>               
            </tr>                      
        </table>
        <br>
        <table class="tabledatos">
            <tr>
                <td>
                    <strong>NOMBRE HUELLA Y FIRMA DEL INSPECTOR </strong>
                </td>
                <td>
                    {{strtoupper($data->inspector->nombres . ' ' . $data->inspector->apellidopaterno . ' ' . $data->inspector->apellidomaterno)}}
                </td>
               
            </tr>  
        </table>
    </div>  
</body>

</html>