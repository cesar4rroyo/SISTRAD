<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Control\Procedimiento;
use App\Models\Control\Rutaprocedimiento;
use App\Models\Control\Area;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProcedimientoController extends Controller
{
    protected $folderview      = 'control.procedimiento';
    protected $tituloAdmin     = 'Procedimiento';
    protected $tituloRegistrar = 'Registrar Procedimiento';
    protected $tituloModificar = 'Modificar Procedimiento';
    protected $tituloEliminar  = 'Eliminar Procedimiento';
    protected $rutas           = array('create' => 'procedimiento.create', 
            'edit'   => 'procedimiento.edit', 
            'delete' => 'procedimiento.eliminar',
            'search' => 'procedimiento.buscar',
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
        $entidad          = 'procedimiento';
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = Procedimiento::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('descripcion', 'ASC');
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
        $entidad          = 'procedimiento';
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
        $entidad  = 'procedimiento';
        $procedimiento = null;
        
        $areas = ["" => "Seleccione un area"];
        $areas += Area::pluck('descripcion', 'id')->all();

        $formData = array('procedimiento.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('procedimiento', 'formData', 'entidad', 'boton', 'listar', 'areas'));
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
        );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
       

        $error = DB::transaction(function() use($request){
            $array_areas = \json_decode($request->input('listAreas') , true);
            $plazo = 0;
            for ($i=0; $i < count($array_areas) ; $i++) { 
                $temp_plazo = $request->input("plazo".$array_areas[$i]["idarea"]);
                if($temp_plazo != "" && $temp_plazo){
                    $plazo  = $plazo + $temp_plazo;
                }
            }

            $procedimiento = new Procedimiento();
            $procedimiento->descripcion   = strtoupper($request->input('descripcion'));
            $procedimiento->observacion   = Libreria::getParam($request->input('observacion'));
            $procedimiento->areainicio_id = $array_areas[0]["idarea"];
            $procedimiento->areafin_id    = $array_areas[count($array_areas)-1]["idarea"];
            $procedimiento->plazo         = $plazo;
            $procedimiento->save();
            
                for ($i=0; $i < count($array_areas) ; $i++) { 
                    $rutaprocedimiento                    = new Rutaprocedimiento();
                    $rutaprocedimiento->areainicial_id    = $array_areas[$i]["idarea"];
                    // $rutaprocedimiento->plazo             = $array_areas[$i]["plazo"];
                    $rutaprocedimiento->plazo             = $request->input("plazo".$array_areas[$i]["idarea"]);
                    $rutaprocedimiento->procedimiento_id        = $procedimiento->id;

                    if(count($array_areas) ==  $i +1 ){
                        $rutaprocedimiento->areafinal_id      = $array_areas[$i]["idarea"];
                    }else{
                        $rutaprocedimiento->areafinal_id    = $array_areas[$i+1]["idarea"];
                    }
                    
                    $rutaprocedimiento->save();
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
        $existe = Libreria::verificarExistencia($id, 'procedimiento');
        if ($existe !== true) {
            return $existe;
        }

        $areas = ["" => "Seleccione un area"];
        $areas += Area::pluck('descripcion', 'id')->all();

        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $procedimiento = Procedimiento::find($id);
        $entidad  = 'procedimiento';
        $formData = array('procedimiento.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('procedimiento', 'formData', 'entidad', 'boton', 'listar' ,'areas'));
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
        $existe = Libreria::verificarExistencia($id, 'procedimiento');

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

            $procedimiento = Procedimiento::find($id);
            $procedimiento->descripcion = strtoupper($request->input('descripcion'));
            $procedimiento->observacion   = Libreria::getParam($request->input('observacion'));
            $procedimiento->areainicio_id = $array_areas[0]["idarea"];
            $procedimiento->areafin_id    = $array_areas[count($array_areas)-1]["idarea"];
            $procedimiento->plazo         = Libreria::getParam($request->input('plazo'));
            $procedimiento->save();

            foreach ($procedimiento->rutas as $ruta) {
               $ruta->delete();
            }

            for ($i=0; $i < count($array_areas) ; $i++) { 
                
                $rutaprocedimiento                    = new Rutaprocedimiento();
                $rutaprocedimiento->areainicial_id    = $array_areas[$i]["idarea"];
                $rutaprocedimiento->plazo             = $request->input("plazo".$array_areas[$i]["idarea"]);
                $rutaprocedimiento->procedimiento_id        = $procedimiento->id;

                if(count($array_areas) ==  $i +1 ){
                    $rutaprocedimiento->areafinal_id      = $array_areas[$i]["idarea"];
                }else{
                    $rutaprocedimiento->areafinal_id    = $array_areas[$i+1]["idarea"];
                }

                $rutaprocedimiento->save();
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
        $existe = Libreria::verificarExistencia($id, 'procedimiento');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $procedimiento = Procedimiento::find($id);
            $procedimiento->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'procedimiento');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Procedimiento::find($id);
        $entidad  = 'procedimiento';
        $formData = array('route' => array('procedimiento.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    
}
