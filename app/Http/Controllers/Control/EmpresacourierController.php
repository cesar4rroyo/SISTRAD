<?php

namespace App\Http\Controllers\Control;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Control\Empresacourier;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Motivo;
use Illuminate\Support\Facades\DB;

class EmpresacourierController extends Controller
{
    protected $folderview      = 'control.empresacourier';
    protected $tituloAdmin     = 'Empresacourier';
    protected $tituloRegistrar = 'Registrar Empresacourier';
    protected $tituloModificar = 'Modificar Empresacourier';
    protected $tituloEliminar  = 'Eliminar Empresacourier';
    protected $rutas           = array('create' => 'empresacourier.create', 
            'edit'   => 'empresacourier.edit', 
            'delete' => 'empresacourier.eliminar',
            'search' => 'empresacourier.buscar',
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
        $entidad          = 'empresacourier';
        $nombre             = Libreria::getParam($request->input('ruc'));
        $resultado        = Empresacourier::where('ruc', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('ruc', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'RUC', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Razón social', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Dirección', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Representante', 'numero' => '1');
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
        $entidad          = 'empresacourier';
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
        $entidad  = 'empresacourier';
        $empresacourier = null;
        
        $formData = array('empresacourier.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('empresacourier', 'formData', 'entidad', 'boton', 'listar'));
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
            'ruc' => 'required',
            'razonsocial' => 'required',
        );
        $mensajes = array(
            'ruc.required'         => 'Debe ingresar el RUC',
            'razonsocial.required'         => 'Debe ingresar la razon social'
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $empresacourier = new Empresacourier();
            $empresacourier->ruc= strtoupper($request->input('ruc'));
            $empresacourier->razonsocial = Libreria::getParam($request->input('razonsocial'), "");
            $empresacourier->representante = Libreria::getParam($request->input('representante'), "");
            $empresacourier->direccion = Libreria::getParam($request->input('direccion'), "");
            $empresacourier->telefono = Libreria::getParam($request->input('telefono'), "");
            $empresacourier->email = Libreria::getParam($request->input('email'), "");
            $empresacourier->save();
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
        $existe = Libreria::verificarExistencia($id, 'empresacourier');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $empresacourier = Empresacourier::find($id);
        $entidad  = 'empresacourier';
        $formData = array('empresacourier.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('empresacourier', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'empresacourier');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'ruc' => 'required',
            'razonsocial' => 'required',
        );
        $mensajes = array(
            'ruc.required'         => 'Debe ingresar el RUC',
            'razonsocial.required'         => 'Debe ingresar la razon social'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $empresacourier = Empresacourier::find($id);
            $empresacourier->ruc= strtoupper($request->input('ruc'));
            $empresacourier->razonsocial = Libreria::getParam($request->input('razonsocial'), "");
            $empresacourier->representante = Libreria::getParam($request->input('representante'), "");
            $empresacourier->direccion = Libreria::getParam($request->input('direccion'), "");
            $empresacourier->telefono = Libreria::getParam($request->input('telefono'), "");
            $empresacourier->email = Libreria::getParam($request->input('email'), "");
            $empresacourier->save();
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
        $existe = Libreria::verificarExistencia($id, 'empresacourier');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $empresacourier = Empresacourier::find($id);
            $empresacourier->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'empresacourier');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Empresacourier::find($id);
        $entidad  = 'empresacourier';
        $formData = array('route' => array('empresacourier.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    
}
