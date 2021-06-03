<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Gestion\Notificacioncargo;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Models\Control\Infraccion;
use App\Models\Gestion\Acta;
use App\Motivo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class NotificacioncargoController extends Controller
{
    protected $folderview      = 'gestion.notificacioncargo';
    protected $tituloAdmin     = 'Notificacioncargo';
    protected $tituloRegistrar = 'Registrar Notificacion de imputación de cargo';
    protected $tituloModificar = 'Modificar Notificacion de imputación de cargo';
    protected $tituloEliminar  = 'Eliminar Notificacion de imputación de cargo';
    protected $rutas           = array('create' => 'notificacioncargo.create', 
            'edit'   => 'notificacioncargo.edit', 
            'delete' => 'notificacioncargo.eliminar',
            'search' => 'notificacioncargo.buscar',
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
        $entidad          = 'notificacioncargo';
        $nombre             = Libreria::getParam($request->input('descripcion'));
        $resultado        = Notificacioncargo::where('descripcion', 'LIKE', '%'.strtoupper($nombre).'%')->orderBy('descripcion', 'ASC');
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha Insp.', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha Notif..', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Infractor', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Personal', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Monto ', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Acta', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Infraccion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '3');
        
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
        $entidad          = 'notificacioncargo';
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
        $entidad  = 'notificacioncargo';
        $notificacioncargo = null;
        $actas = [""=> "Seleccione"] + Acta::pluck('numero', 'id')->all();
        $infracciones = ["" =>"Seleccione"] + Infraccion::pluck('codigo' , 'id')->all(); 
        $formData = array('notificacioncargo.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('notificacioncargo', 'formData', 'entidad', 'boton', 'listar','actas' , 'infracciones'));
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
            'fecha_inspeccion' => 'required',
            'fecha_notificacion' => 'required',
            'nombre' => 'required',
            'numero' => 'required',
            'nro_documento' => 'required',
            'p_nombre' => 'required',
            'p_nro_documento' => 'required',
            'calle' => 'required',
            'i_calle' => 'required',
            'infraccion_id' => 'required',
            'i_monto' => 'required|numeric',
            'descripcion' => 'required',
        );
        $mensajes = array(
            'fecha_inspeccion.required'          => 'Debe ingresar la fecha de la inspección',
            'fecha_notificacion.required'        => 'Debe ingresar la fecha de la notificación',
            'nombre.required'                    => 'Debe ingresar el nombre o razón social del infractor',
            'nro_documento.required'             => 'Debe ingresar el nro de documento del infractor',
            'p_nombre.required'                  => 'Debe ingresar el nombre de la persona a cargo',
            'p_nro_documento.required'           => 'Debe ingresar el nro de documento de la persona a cargo',
            'calle.required'                     => 'Debe ingresar la direccion del infractor',
            'i_calle.required'                   => 'Debe ingresar el lugar de la infracción',
            'infraccion_id.required'             => 'Seleccione la infracción cometida',
            'monto.required'                     => 'Ingrese el monto',
            'descripcion.required'               => 'Debe ingresar una descripción',
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $notificacioncargo = new Notificacioncargo();
            $notificacioncargo->numero = Libreria::getParam($request->input('numero'));
            $notificacioncargo->fecha_inspeccion = Libreria::getParam($request->input('fecha_inspeccion')).' '.date('H:i:s');
            $notificacioncargo->fecha_notificacion = Libreria::getParam($request->input('fecha_notificacion')).' '.date('H:i:s');
            $notificacioncargo->nombre = Libreria::getParam($request->input('nombre'));
            $notificacioncargo->nro_documento = Libreria::getParam($request->input('nro_documento'));
            $notificacioncargo->p_nombre = Libreria::getParam($request->input('p_nombre'));
            $notificacioncargo->p_nro_documento = Libreria::getParam($request->input('p_nro_documento'));
            $notificacioncargo->calle = Libreria::getParam($request->input('calle'));
            $notificacioncargo->nro = Libreria::getParam($request->input('nro'));
            $notificacioncargo->sector = Libreria::getParam($request->input('sector'));
            $notificacioncargo->manzana = Libreria::getParam($request->input('manzana'));
            $notificacioncargo->lote = Libreria::getParam($request->input('lote'));
            $notificacioncargo->urbanizacion = Libreria::getParam($request->input('urbanizacion'));
            $notificacioncargo->distrito = Libreria::getParam($request->input('distrito'));
            $notificacioncargo->i_calle = Libreria::getParam($request->input('i_calle'));
            $notificacioncargo->i_nro = Libreria::getParam($request->input('i_nro'));
            $notificacioncargo->i_sector = Libreria::getParam($request->input('i_sector'));
            $notificacioncargo->i_manzana = Libreria::getParam($request->input('i_manzana'));
            $notificacioncargo->i_lote = Libreria::getParam($request->input('i_lote'));
            $notificacioncargo->i_urbanizacion = Libreria::getParam($request->input('i_urbanizacion'));
            $notificacioncargo->i_distrito = Libreria::getParam($request->input('i_distrito'));
            $notificacioncargo->i_monto = Libreria::getParam($request->input('i_monto'));
            if($request->input('actafiscalizacion_id') && $request->input('actafiscalizacion_id') != ''){
                $notificacioncargo->actafiscalizacion_id = Libreria::getParam($request->input('actafiscalizacion_id'));
            }
            $notificacioncargo->infraccion_id = Libreria::getParam($request->input('infraccion_id'));
            $notificacioncargo->plazo = 6;
            $notificacioncargo->descripcion= Libreria::getParam($request->input('descripcion'));
            $notificacioncargo->save();
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
        $existe = Libreria::verificarExistencia($id, 'notificacioncargo');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $notificacioncargo = Notificacioncargo::find($id);
        $actas = [""=> "Seleccione"] + Acta::pluck('numero', 'id')->all();
        $infracciones = ["" =>"Seleccione"] + Infraccion::pluck('codigo' , 'id')->all(); 
        $entidad  = 'notificacioncargo';
        $formData = array('notificacioncargo.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('notificacioncargo', 'formData', 'entidad', 'boton', 'listar', 'actas','infracciones'));
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
        $existe = Libreria::verificarExistencia($id, 'notificacioncargo');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'fecha_inspeccion' => 'required',
            'fecha_notificacion' => 'required',
            'nombre' => 'required',
            'numero' => 'required',
            'nro_documento' => 'required',
            'p_nombre' => 'required',
            'p_nro_documento' => 'required',
            'calle' => 'required',
            'distrito' => 'required',
            'i_calle' => 'required',
            'i_distrito' => 'required',
            'infraccion_id' => 'required',
            'i_monto' => 'required|numeric',
            'descripcion' => 'required',
        );
        $mensajes = array(
            'fecha_inspeccion.required'          => 'Debe ingresar la fecha de la inspección',
            'fecha_notificacion.required'        => 'Debe ingresar la fecha de la notificación',
            'nombre.required'                    => 'Debe ingresar el nombre o razón social del infractor',
            'nro_documento.required'             => 'Debe ingresar el nro de documento del infractor',
            'p_nombre.required'                  => 'Debe ingresar el nombre de la persona a cargo',
            'p_nro_documento.required'           => 'Debe ingresar el nro de documento de la persona a cargo',
            'calle.required'                     => 'Debe ingresar la direccion del infractor',
            'i_calle.required'                   => 'Debe ingresar el lugar de la infracción',
            'infraccion_id.required'             => 'Seleccione la infracción cometida',
            'monto.required'                     => 'Ingrese el monto',
            'descripcion.required'               => 'Debe ingresar una descripción',
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $notificacioncargo = Notificacioncargo::find($id);
            $notificacioncargo->numero = Libreria::getParam($request->input('numero'));
            $notificacioncargo->fecha_inspeccion = Libreria::getParam($request->input('fecha_inspeccion')).' '.date('H:i:s');
            $notificacioncargo->fecha_notificacion = Libreria::getParam($request->input('fecha_notificacion')).' '.date('H:i:s');
            $notificacioncargo->nombre = Libreria::getParam($request->input('nombre'));
            $notificacioncargo->nro_documento = Libreria::getParam($request->input('nro_documento'));
            $notificacioncargo->p_nombre = Libreria::getParam($request->input('p_nombre'));
            $notificacioncargo->p_nro_documento = Libreria::getParam($request->input('p_nro_documento'));
            $notificacioncargo->calle = Libreria::getParam($request->input('calle'));
            $notificacioncargo->nro = Libreria::getParam($request->input('nro'));
            $notificacioncargo->sector = Libreria::getParam($request->input('sector'));
            $notificacioncargo->manzana = Libreria::getParam($request->input('manzana'));
            $notificacioncargo->lote = Libreria::getParam($request->input('lote'));
            $notificacioncargo->urbanizacion = Libreria::getParam($request->input('urbanizacion'));
            $notificacioncargo->distrito = Libreria::getParam($request->input('distrito'));
            $notificacioncargo->i_calle = Libreria::getParam($request->input('i_calle'));
            $notificacioncargo->i_nro = Libreria::getParam($request->input('i_nro'));
            $notificacioncargo->i_sector = Libreria::getParam($request->input('i_sector'));
            $notificacioncargo->i_manzana = Libreria::getParam($request->input('i_manzana'));
            $notificacioncargo->i_lote = Libreria::getParam($request->input('i_lote'));
            $notificacioncargo->i_urbanizacion = Libreria::getParam($request->input('i_urbanizacion'));
            $notificacioncargo->i_distrito = Libreria::getParam($request->input('i_distrito'));
            $notificacioncargo->i_monto = Libreria::getParam($request->input('i_monto'));
            if($request->input('actafiscalizacion_id') && $request->input('actafiscalizacion_id') != ''){
                $notificacioncargo->actafiscalizacion_id = Libreria::getParam($request->input('actafiscalizacion_id'));
            }
            $notificacioncargo->infraccion_id = Libreria::getParam($request->input('infraccion_id'));
            $notificacioncargo->plazo = 6;
            $notificacioncargo->descripcion= Libreria::getParam($request->input('descripcion'));
            $notificacioncargo->save();
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
        $existe = Libreria::verificarExistencia($id, 'notificacioncargo');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $notificacioncargo = Notificacioncargo::find($id);
            $notificacioncargo->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'notificacioncargo');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Notificacioncargo::find($id);
        $entidad  = 'notificacioncargo';
        $formData = array('route' => array('notificacioncargo.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'notificacioncargo');
        if ($existe !== true) {
            return $existe;
        }

        $notificacioncargo = Notificacioncargo::find($id);
        // $obj = new Enletras();
        // $enletras = $obj->ValorEnLetras($Notificacioncargo->monto , 'soles');

        $pdf = PDF::loadView($this->folderview.'.pdf' , compact('notificacioncargo' ))->setPaper('a4');
        //HOJA HORIZONTAL ->setPaper('a4', 'landscape')
    //descargar
       // return $pdf->download('F'.$cotizacion->documento->correlativo.'.pdf');  
    //Ver
       return $pdf->stream('notificacioncargo.pdf');
    }
    
    
}
