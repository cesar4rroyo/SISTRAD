<?php

namespace App\Http\Controllers\Control;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Control\Subtipotramitenodoc;
use App\Models\Control\Tipotramitenodoc;
use Illuminate\Support\Facades\DB;

class SubtipotramitenodocController extends Controller
{
    protected $folderview      = 'control.subtipotramitenodoc';
    protected $tituloAdmin     = 'subtipotramitenodoc';
    protected $tituloRegistrar = 'Registrar Subtipo de Tramite no documentario';
    protected $tituloModificar = 'Modificar Subtipo de tramite no documentario';
    protected $tituloEliminar  = 'Eliminar Subtipo de tramite no documentario';
    protected $rutas           = array('create' => 'subtipotramitenodoc.create', 
            'edit'   => 'subtipotramitenodoc.edit', 
            'delete' => 'subtipotramitenodoc.eliminar',
            'search' => 'subtipotramitenodoc.buscar',
            'index'  => 'subtipotramitenodoc.index',
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
        $entidad          = 'subtipotramitenodoc';
        $nombre           = Libreria::getParam($request->input('descripcion'));
        $tipotramite      = Libreria::getParam($request->input('tipotramite'));
        // $codigo           = Libreria::getParam($request->input('txtcodigo'));
        $resultado        = Subtipotramitenodoc::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')
                            ->where( function($query) use ($tipotramite){
                                if(!is_null($tipotramite) && strlen($tipotramite) > 0){
                                    $query->where('tipotramitenodoc_id' , $tipotramite);
                                }
                            })
                            ->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo trámite', 'numero' => '1');
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
        $entidad          = 'subtipotramitenodoc';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $tipostramite     = ['' => 'Todos'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta' , 'tipostramite'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'subtipotramitenodoc';
        $subtipotramitenodoc = null;
        
        $formData = array('subtipotramitenodoc.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        $tipostramite     = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        return view($this->folderview.'.mant')->with(compact('subtipotramitenodoc', 'formData', 'entidad', 'boton', 'listar' , 'tipostramite'));
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
            'tipotramite' => 'required|exists:tipotramitenodoc,id'
    );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'tipotramite.required'         => 'Debe seleccionar el tipo de trámite al que pertenece',
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $subtipotramitenodoc = new Subtipotramitenodoc();
            $subtipotramitenodoc->descripcion= strtoupper($request->input('descripcion'));
            $subtipotramitenodoc->tipotramitenodoc_id = $request->input('tipotramite');
            $subtipotramitenodoc->save();
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
        $existe = Libreria::verificarExistencia($id, 'subtipotramitenodoc');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $subtipotramitenodoc = Subtipotramitenodoc::find($id);
        $entidad  = 'subtipotramitenodoc';
        $formData = array('subtipotramitenodoc.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $tipostramite     = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        return view($this->folderview.'.mant')->with(compact('subtipotramitenodoc', 'formData', 'entidad', 'boton', 'listar' , 'tipostramite'));
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
        $existe = Libreria::verificarExistencia($id, 'subtipotramitenodoc');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'descripcion' => 'required',
            'tipotramite' => 'required|exists:tipotramitenodoc,id'
    );
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción',
            'tipotramite.required'         => 'Debe seleccionar el tipo de trámite al que pertenece',
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $subtipotramitenodoc = Subtipotramitenodoc::find($id);
            $subtipotramitenodoc->descripcion = strtoupper($request->input('descripcion'));
            $subtipotramitenodoc->tipotramitenodoc_id = $request->input('tipotramite');
            $subtipotramitenodoc->save();
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
        $existe = Libreria::verificarExistencia($id, 'subtipotramitenodoc');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $subtipotramitenodoc = Subtipotramitenodoc::find($id);
            $subtipotramitenodoc->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'subtipotramitenodoc');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Subtipotramitenodoc::find($id);
        $entidad  = 'subtipotramitenodoc';
        $formData = array('route' => array('subtipotramitenodoc.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
}
