<?php

namespace App\Http\Controllers\Contribuyente;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Contribuyente\Pretramite;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Motivo;
use DateTime;
use Illuminate\Support\Facades\DB;

class PretramiteController extends Controller
{
    protected $folderview      = 'contribuyente.pretramite';
    protected $tituloAdmin     = 'Pretramite';
    protected $tituloRegistrar = 'Registrar Pretramite';
    protected $tituloModificar = 'Detalles Pretramite';
    protected $tituloEliminar  = 'Eliminar Pretramite';
    protected $tituloAceptar  = 'Aceptar Pretramite';
    protected $tituloRechazar  = 'Rechazar Pretramite';
    protected $rutas           = array('create' => 'pretramite.create', 
            'edit'   => 'pretramite.edit', 
            'aceptar' => 'pretramite.aceptar',
            'rechazar' => 'pretramite.rechazar',
            'delete' => 'pretramite.eliminar',
            'search' => 'pretramite.buscar',
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
        $entidad          = 'pretramite';
        $nombre             = Libreria::getParam($request->input('asunto'));


        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $remitente    = Libreria::getParam($request->input('remitente'));
        $estado             = Libreria::getParam($request->input('estado'));

        $resultado        = Pretramite::listar($numero, $fecinicio, $fecfin, $remitente , $estado);

        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Numero', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha envío', 'numero' => '1');
        $cabecera[]       = array('valor' => 'F. Revisado', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Remitente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $titulo_aceptar = $this->tituloAceptar;
        $titulo_rechazar = $this->tituloRechazar;
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar' , 'titulo_aceptar','titulo_rechazar', 'titulo_eliminar', 'ruta'));
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
        $entidad          = 'pretramite';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $titulo_aceptar = $this->tituloAceptar;
        $titulo_rechazar = $this->tituloRechazar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar','titulo_aceptar','titulo_rechazar', 'ruta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'pretramite';
        $pretramite = null;
        
        $formData = array('pretramite.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('pretramite', 'formData', 'entidad', 'boton', 'listar'));
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
        $reglas     = array('descripcion' => 'required');
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripción'
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $pretramite = new Pretramite();
            $pretramite->descripcion= strtoupper($request->input('descripcion'));
            $pretramite->mesadepartes= $request->input('mesadepartes')?true:false;
            $pretramite->save();
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
        $formData = array('pretramite.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
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
        $existe = Libreria::verificarExistencia($id, 'pretramite');

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
            $pretramite = Pretramite::find($id);
            $pretramite->descripcion = strtoupper($request->input('descripcion'));
            $pretramite->mesadepartes= $request->input('mesadepartes')?true:false;
            $pretramite->save();
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
        $existe = Libreria::verificarExistencia($id, 'pretramite');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $pretramite = Pretramite::find($id);
            $pretramite->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'pretramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Pretramite::find($id);
        $entidad  = 'pretramite';
        $formData = array('route' => array('pretramite.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function rechazar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'pretramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Pretramite::find($id);
        $entidad  = 'pretramite';
        $formData = array('route' => array('pretramite.confirmarrechazar', $id), 'method' => 'GET', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Rechazar';
        $boton_class    = ' btn-danger';
        $tipo     = 'RECHAZAR';
        return view($this->folderview.'.accion')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar', 'tipo', 'boton_class'));
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmarrechazar($id , Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'pretramite');
        if ($existe !== true) {
            return $existe;
        
        }
        $reglas     = array('motivo_rechazo' => 'required');
        $mensajes = array(
            'motivo_rechazo.required'         => 'Debe ingresar el motivo del rechazo'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($id , $request){
            $pretramite = Pretramite::find($id);
            $pretramite->estado = 'RECHAZADO';
            $pretramite->fecha_rechazado = new DateTime('now');
            $pretramite->motivo_rechazo = Libreria::getParam($request->input('motivo_rechazo'));
            $pretramite->save();
        });
        return is_null($error) ? "OK" : $error;
    }
}
