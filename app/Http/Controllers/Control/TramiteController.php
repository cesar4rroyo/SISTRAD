<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Control\Tramite;
use App\Models\Control\Rutatramite;
use App\Models\Control\Area;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TramiteController extends Controller
{
    protected $folderview      = 'control.tramite';
    protected $tituloAdmin     = 'Tramite';
    protected $tituloRegistrar = 'Registrar Tramite';
    protected $tituloModificar = 'Modificar Tramite';
    protected $tituloEliminar  = 'Eliminar Tramite';
    protected $rutas           = array('create' => 'tramite.create', 
            'edit'   => 'tramite.edit', 
            'delete' => 'tramite.eliminar',
            'search' => 'tramite.buscar',
            'index'  => 'anio.index',
        );


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Mostrar el resultado de búsquedas
     * 
     * @return Response 
     */
    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'tramite';
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = Tramite::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Area Inic.', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Area fin', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Plazo (dias)', 'numero' => '1');
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
        $entidad          = 'tramite';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'tramite';
        $tramite = null;
        
        $areas = ["" => "Seleccione un area"];
        $areas += Area::pluck('descripcion', 'id')->all();

        $formData = array('tramite.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('tramite', 'formData', 'entidad', 'boton', 'listar', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas     = array(
            'descripcion' => 'required',
            'plazo' => 'required|integer',
        );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'plazo.required'         => 'Debe ingresar el plazo',
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
       

        $error = DB::transaction(function() use($request){
            $array_areas = \json_decode($request->input('listAreas') , true);

            $tramite = new Tramite();
            $tramite->descripcion   = strtoupper($request->input('descripcion'));
            $tramite->observacion   = Libreria::getParam($request->input('observacion'));
            $tramite->areainicio_id = $array_areas[0]["idarea"];
            $tramite->areafin_id    = $array_areas[count($array_areas)-1]["idarea"];
            $tramite->plazo         = Libreria::getParam($request->input('plazo'));
            $tramite->save();
            
                for ($i=0; $i < count($array_areas) ; $i++) { 
                    $rutatramite                    = new Rutatramite();
                    $rutatramite->areainicial_id    = $array_areas[$i]["idarea"];
                    // $rutatramite->plazo             = $array_areas[$i]["plazo"];
                    $rutatramite->plazo             = $request->input("plazo".$array_areas[$i]["idarea"]);
                    $rutatramite->tramite_id        = $tramite->id;

                    if(count($array_areas) ==  $i +1 ){
                        $rutatramite->areafinal_id      = $array_areas[$i]["idarea"];
                    }else{
                        $rutatramite->areafinal_id    = $array_areas[$i+1]["idarea"];
                    }
                    
                    $rutatramite->save();
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
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }

        $areas = ["" => "Seleccione un area"];
        $areas += Area::pluck('descripcion', 'id')->all();

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $tramite = Tramite::find($id);
        $entidad  = 'tramite';
        $formData = array('tramite.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('tramite', 'formData', 'entidad', 'boton', 'listar' ,'areas'));
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
        $existe = Libreria::verificarExistencia($id, 'tramite');

        if ($existe !== true) {
            return $existe;
        }
            $reglas     = array(
                'descripcion' => 'required',
                'plazo' => 'required|integer',
            );
            $mensajes = array(
                'descripcion.required'         => 'Debe ingresar una descripción',
                'plazo.required'         => 'Debe ingresar el plazo',
                );
                
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){

            $array_areas = \json_decode($request->input('listAreas') , true);

            $tramite = Tramite::find($id);
            $tramite->descripcion = strtoupper($request->input('descripcion'));
            $tramite->observacion   = Libreria::getParam($request->input('observacion'));
            $tramite->areainicio_id = $array_areas[0]["idarea"];
            $tramite->areafin_id    = $array_areas[count($array_areas)-1]["idarea"];
            $tramite->plazo         = Libreria::getParam($request->input('plazo'));
            $tramite->save();

            foreach ($tramite->rutas as $ruta) {
               $ruta->delete();
            }

            for ($i=0; $i < count($array_areas) ; $i++) { 
                
                $rutatramite                    = new Rutatramite();
                $rutatramite->areainicial_id    = $array_areas[$i]["idarea"];
                $rutatramite->plazo             = $request->input("plazo".$array_areas[$i]["idarea"]);
                $rutatramite->tramite_id        = $tramite->id;

                if(count($array_areas) ==  $i +1 ){
                    $rutatramite->areafinal_id      = $array_areas[$i]["idarea"];
                }else{
                    $rutatramite->areafinal_id    = $array_areas[$i+1]["idarea"];
                }

                $rutatramite->save();
            }

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
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $tramite = Tramite::find($id);
            $tramite->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Tramite::find($id);
        $entidad  = 'tramite';
        $formData = array('route' => array('tramite.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    
}
