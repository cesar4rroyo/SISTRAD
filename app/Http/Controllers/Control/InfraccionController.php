<?php

namespace App\Http\Controllers\Control;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Control\Infraccion;
use App\Models\Control\UIT;
use Illuminate\Support\Facades\DB;


class InfraccionController extends Controller
{
    protected $folderview      = 'control.infraccion';
    protected $tituloAdmin     = 'infraccion';
    protected $tituloRegistrar = 'Registrar Infraccion';
    protected $tituloModificar = 'Modificar Infraccion';
    protected $tituloEliminar  = 'Eliminar Infraccion';
    protected $rutas           = array('create' => 'infraccion.create', 
            'edit'   => 'infraccion.edit', 
            'delete' => 'infraccion.eliminar',
            'search' => 'infraccion.buscar',
            'index'  => 'infraccion.index',
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
        $entidad          = 'infraccion';
        $nombre           = Libreria::getParam($request->input('descripcion'));
        // $codigo           = Libreria::getParam($request->input('txtcodigo'));
        $resultado        = Infraccion::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')
                                ->orWhere('codigo', 'LIKE', '%'.strtoupper($nombre).'%')
                                ->orWhere('procedimiento', 'LIKE', '%'.strtoupper($nombre).'%')
                                ->orWhere('tipo', 'LIKE', '%'.strtoupper($nombre).'%')
                                ->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Procedimiento', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Medida Complementaria', 'numero' => '1');
        $cabecera[]       = array('valor' => '%UIT', 'numero' => '1');
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
        $entidad          = 'infraccion';
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
        $entidad  = 'infraccion';
        $infraccion = null;
        if($request->tipo=='uit'){
            $uit = UIT::orderby('created_at', 'desc')->first();
            $formData = array('infraccion.uit');
            $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
            $boton    = 'Registrar'; 
            return view($this->folderview.'.uit')->with(compact('infraccion', 'formData', 'entidad', 'boton', 'listar', 'uit'));

        }
        $formData = array('infraccion.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('infraccion', 'formData', 'entidad', 'boton', 'listar'));
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
            'procedimiento'=>'required',
            'codigo'=>'required',
            'tipo'=>'required',
            'medidacomplementaria'=>'required',
            'uit'=>'required',
        );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'procedimiento.required' => 'Debe ingresar el procedimiento',
            'tipo.required' => 'Debe ingresar el tipo',
            'codigo.required' => 'Debe ingresar el codigo',
            'medidacomplementaria.required' => 'Debe ingresar la medida complementaria',
            'uit.required' => 'Debe ingresar el porcentaje de UIT',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $error = DB::transaction(function() use($request){
            $infraccion = new Infraccion();
            $infraccion->descripcion= strtoupper($request->input('descripcion'));
            $infraccion->procedimiento= strtoupper($request->input('procedimiento'));
            $infraccion->tipo= strtoupper($request->input('tipo'));
            $infraccion->codigo= strtoupper($request->input('codigo'));
            $infraccion->medidacomplementaria= strtoupper($request->input('medidacomplementaria'));
            $infraccion->uit= $request->input('uit');
            $infraccion->save();
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
    public function uit(Request $request){
        $reglas     = array(
            'uit' => 'required', 
        );
        $mensajes = array(
            'uit.required'         => 'Debe ingresar el valor de la UIT',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request){
            $uitvalue = new UIT();
            $uitvalue->valor= $request->input('uit');
            $uitvalue->save();
        });

        return is_null($error) ? "OK" : $error;
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'infraccion');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $infraccion = infraccion::find($id);
        $entidad  = 'infraccion';
        $formData = array('infraccion.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('infraccion', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'infraccion');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'descripcion' => 'required', 
            'procedimiento'=>'required',
            'codigo'=>'required',
            'tipo'=>'required',
            'medidacomplementaria'=>'required',
            'uit'=>'required',
        );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'procedimiento.required' => 'Debe ingresar el procedimiento',
            'tipo.required' => 'Debe ingresar el tipo',
            'codigo.required' => 'Debe ingresar el codigo',
            'medidacomplementaria.required' => 'Debe ingresar la medida complementaria',
            'uit.required' => 'Debe ingresar el porcentaje de UIT',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $infraccion = Infraccion::find($id);
            $infraccion->descripcion= strtoupper($request->input('descripcion'));
            $infraccion->procedimiento= strtoupper($request->input('procedimiento'));
            $infraccion->tipo= strtoupper($request->input('tipo'));
            $infraccion->codigo= strtoupper($request->input('codigo'));
            $infraccion->medidacomplementaria= strtoupper($request->input('medidacomplementaria'));
            $infraccion->uit= $request->input('uit');
            $infraccion->save();
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
        $existe = Libreria::verificarExistencia($id, 'infraccion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $infraccion = Infraccion::find($id);
            $infraccion->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'infraccion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Infraccion::find($id);
        $entidad  = 'infraccion';
        $formData = array('route' => array('infraccion.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
}
