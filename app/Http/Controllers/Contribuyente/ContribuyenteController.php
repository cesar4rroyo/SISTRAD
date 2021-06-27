<?php

namespace App\Http\Controllers\Contribuyente;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Control\Area;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Models\Contribuyente\Archivopretramite;
use App\Models\Contribuyente\Pretramite;
use App\Models\Gestion\Tramite;
use App\Motivo;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Barryvdh\DomPDF\Facade as PDF;


class ContribuyenteController extends Controller
{
    protected $folderview      = 'contribuyente';
    protected $tituloAdmin     = 'Area';
    protected $tituloRegistrar = 'Registrar Area';
    protected $tituloModificar = 'Detalles del trámite virtual';
    protected $tituloEliminar  = 'Eliminar Area';
    protected $rutas           = array('create' => 'contribuyente.create', 
            'edit'   => 'contribuyente.edit', 
            'delete' => 'contribuyente.eliminar',
            'search' => 'contribuyente.buscar',
            'index'  => 'contribuyente.index',
        );



    /**
     * Mostrar el resultado de búsquedas
     * 
     * @return Response 
     */
    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'area';
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = Area::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pretramite = null;
        $entidad = 'pretramite';
        $formData = array('area.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal m-4', 'id' => 'pretramite-form', 'autocomplete' => 'off');
       
        return view($this->folderview.'.form')->with(compact('formData', 'pretramite', 'entidad'));
    }
    
    public function busqueda()
    {
        $entidad = '';
        return view($this->folderview.'.busqueda')->with(compact('entidad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'area';
        $area = null;
        
        $formData = array('area.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('area', 'formData', 'entidad', 'boton', 'listar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registrarTramite(Request $request)
    {
        $reglas     = array(
            'dni' => 'required',
            'remitente' => 'required',
            'asunto' => 'required',
            'correo' => 'required',
        );
        $mensajes = array(
            'dni.required'         => 'Debe ingresar su número de DNI',
            'remitente.required'         => 'Debe ingresar sus nombres y apellidos',
            'asunto.required'         => 'Debe ingresar el asunto del trámite',
            'correo.required'         => 'Debe ingresar su correo',
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $pretramite = new Pretramite();
            $pretramite->numero     = Pretramite::NumeroSigue();
            $pretramite->asunto     = strtoupper($request->input('asunto'));
            $pretramite->dni        = strtoupper($request->input('dni'));
            $pretramite->remitente  = strtoupper($request->input('remitente'));
            $pretramite->comentario = strtoupper($request->input('comentario'));
            $pretramite->correo     = strtoupper($request->input('correo'));
            $pretramite->telefono   = strtoupper($request->input('telefono'));
            $pretramite->estado     = 'PENDIENTE';
            $pretramite->save();

            $arr = explode(",", $request->input('listArchivos'));
                    for ($c = 0; $c < count($arr); $c++) {
                        if($request->hasFile($arr[$c])){
                            $archivopretramite = new Archivopretramite();

                            $file = $request->file($arr[$c]);
                            $extension = $request->file($arr[$c])->getClientOriginalExtension();
                            $nombre =  time().'.'.$extension;
                            \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                            // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                            $archivopretramite->archivo = $nombre;
                            $archivopretramite->descripcion = Libreria::getParam($request->input($arr[$c].'_text'));
                            $archivopretramite->pretramite_id = $pretramite->id;
                            $archivopretramite->save();
                        }
                    }
        });

        return is_null($error) ? "OK" : $error;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'pretramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $pretramite = Pretramite::find($id);
        $entidad  = 'pretramite';
        $formData = array('area.update', $id);
        $formData = array('route' =>'', 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('pretramite', 'formData', 'entidad', 'boton', 'listar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'area');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array('descripcion' => 'required');
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripcion'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $area = Area::find($id);
            $area->descripcion = strtoupper($request->input('descripcion'));
            $area->mesadepartes= $request->input('mesadepartes')?true:false;
            $area->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'area');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $area = Area::find($id);
            $area->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'area');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Area::find($id);
        $entidad  = 'area';
        $formData = array('route' => array('area.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function buscarDNI(Request $request)
    {
        dd($request->input('dni'));
        $respuesta = array();
        $dni = $request->input('dni');
        $client = new Client();
        $res = $client->get('http://facturae-garzasoft.com/facturacion/buscaCliente/BuscaCliente2.php?' . 'dni=' . $dni . '&fe=N&token=qusEj_w7aHEpX');
        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
            $respuesta = json_decode($response_data);
        }
        return json_encode($respuesta);
    }
    public function buscarTramite(Request $request)
    {
        $numero = $request->input('numero');
        $dni = $request->input('dni');
        $pretramite = null;
        $tramite = null;
        $pretramite = Pretramite::where('numero', $numero)->where('dni' , $dni)->first();
        if($pretramite){
            $tramite = Tramite::where('pretramite_id', $pretramite->id)->first();
        }
        
        return view($this->folderview.'.resultado')->with(compact('pretramite','tramite'));
    }

    public function printseguimiento($id){
        $tramite = Tramite::with('seguimientos.areas')->find($id);
        $data = $tramite;
        $pdf = PDF::loadView('gestion.pdf.seguimiento', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('seguimiento.pdf');
    }
    
    
}
