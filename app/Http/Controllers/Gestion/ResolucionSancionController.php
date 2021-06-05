<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Librerias\Libreria;
use App\Models\Gestion\ResolucionSancion;
use App\Librerias\EnLetras;
use App\Models\Gestion\Acta;
use App\Models\Gestion\Notificacioncargo;

class ResolucionSancionController extends Controller
{
    protected $folderview      = 'gestion.resolucionsancion';
    protected $tituloAdmin     = 'resolucionsancion';
    protected $tituloRegistrar = 'Registrar Resolucion de Sanción Administrativa';
    protected $tituloModificar = 'Modificar Resolucion de Sanción Administrativa';
    protected $tituloEliminar  = 'Eliminar Resolucion de Sanción Administrativa';
    protected $rutas           = array(
            'create' => 'resolucionsancion.create', 
            'edit'   => 'resolucionsancion.edit', 
            'delete' => 'resolucionsancion.eliminar',
            'search' => 'resolucionsancion.buscar',
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
        $entidad          = 'resolucionsancion';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
       // $contribuyente    = Libreria::getParam($request->input('contribuyente'));
       // $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = ResolucionSancion::listar($numero, $fecinicio, $fecfin);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ordenanza', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro. Acta Fiscalización', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro. Notificación ', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '1');
        
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
        $entidad          = 'resolucionsancion';
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
        $entidad  = 'resolucionsancion';
        $resolucionsancion = null;     
        $formData = array('resolucionsancion.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        $actas = [""=> "Seleccione"] + Acta::pluck('numero', 'id')->all();
        $notificacion = [""=> "Seleccione"] + Notificacioncargo::pluck('numero', 'id')->all();
        
        return view($this->folderview.'.mant')->with(compact('actas', 'notificacion','resolucionsancion', 'formData', 'entidad', 'boton', 'listar'));
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
            'fechaemision' => 'required',
            'numero' => 'required',
            'ordenanza' => 'required',
            'descargo' => 'required',
            'conclusion' => 'required',
            'fojas' => 'required',
            'periodo' => 'required',
            'actafiscalizacion_id' => 'required',
            'notificacioncargo_id' => 'required',
            'nroinstruccion' => 'required',
            'domicilioprocesal' => 'required',
            'fechainstruccion' => 'required',


        );
        $mensajes = array(
            'fechaemision.required'         => 'Debe ingresar la fecha',
            'fechainstruccion.required'         => 'Debe ingresar la fecha del informe de instruccion',
            'numero.required'         => 'Debe ingresar el numero',
            'ordenanza.required'         => 'Debe ingresar la Ordenanza',
            'fojas.required'         => 'Debe ingresar el numero de fojas',
            'periodo.required'         => 'Debe ingresar el periodo',
            'conclusion.required'         => 'Debe ingresar las conclusiones',
            'descargo.required'         => 'Debe ingresar el descargo',
            'nroinstruccion.required'         => 'Debe ingresar el Nro. de Instrucción',
            'domicilioprocesal.required'         => 'Debe ingresar el domicilio procesal',
            'actafiscalizacion_id.required'         => 'Debe ingresar la Acta de Fiscalizacion',
            'notificacioncargo_id.required'         => 'Debe ingresar la Notificacion de Cargo',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $error = DB::transaction(function() use($request){
            $resolucionsancion = new ResolucionSancion();
            $resolucionsancion->fechaemision                 = $request->fechaemision;
            $resolucionsancion->fechainstruccion                 = $request->fechainstruccion;
            $resolucionsancion->estado = 'REGISTRADO';
            $resolucionsancion->monto=0; //modifciar despues XD tengo examen :v
            $resolucionsancion->ordenanza            = strtoupper(Libreria::getParam($request->input('ordenanza')));
            $resolucionsancion->numero            = strtoupper(Libreria::getParam($request->input('numero')));
            $resolucionsancion->nroinstruccion            = strtoupper(Libreria::getParam($request->input('nroinstruccion')));
            $resolucionsancion->domicilioprocesal            = strtoupper(Libreria::getParam($request->input('domicilioprocesal')));
            $resolucionsancion->fojas            = strtoupper(Libreria::getParam($request->input('fojas')));
            $resolucionsancion->descargo            = strtoupper(Libreria::getParam($request->input('descargo')));
            $resolucionsancion->conclusion            = strtoupper(Libreria::getParam($request->input('conclusion')));
            $resolucionsancion->medidacorrectiva            = strtoupper(Libreria::getParam($request->input('medidacorrectiva')));
            $resolucionsancion->periodo            = strtoupper(Libreria::getParam($request->input('periodo')));
            $resolucionsancion->actafiscalizacion_id            = strtoupper(Libreria::getParam($request->input('actafiscalizacion_id')));
            $resolucionsancion->notificacioncargo_id            = strtoupper(Libreria::getParam($request->input('notificacioncargo_id')));
            $resolucionsancion->save();

        });
        $ultimo = resolucionsancion::orderBy('id', 'DESC')->first()->toArray()['id'];

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
        $existe = Libreria::verificarExistencia($id, 'resolucionsancion');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $resolucionsancion = resolucionsancion::find($id);
        $entidad  = 'resolucionsancion';
        $formData = array('resolucionsancion.update', $id);
        $actas = [""=> "Seleccione"] + Acta::pluck('numero', 'id')->all();
        $notificacion = [""=> "Seleccione"] + Notificacioncargo::pluck('numero', 'id')->all();
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('resolucionsancion', 'formData', 'entidad', 'boton', 'listar', 'actas', 'notificacion'));
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
        $existe = Libreria::verificarExistencia($id, 'resolucionsancion');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'fechaemision' => 'required',
            'numero' => 'required',
            'ordenanza' => 'required',
            'descargo' => 'required',
            'conclusion' => 'required',
            'fojas' => 'required',
            'periodo' => 'required',
            'actafiscalizacion_id' => 'required',
            'notificacioncargo_id' => 'required',
            'nroinstruccion' => 'required',
            'domicilioprocesal' => 'required',

        );
        $mensajes = array(
            'fechaemision.required'         => 'Debe ingresar la fecha',
            'numero.required'         => 'Debe ingresar el numero',
            'ordenanza.required'         => 'Debe ingresar la Ordenanza',
            'fojas.required'         => 'Debe ingresar el numero de fojas',
            'periodo.required'         => 'Debe ingresar el periodo',
            'conclusion.required'         => 'Debe ingresar las conclusiones',
            'descargo.required'         => 'Debe ingresar el descargo',
            'nroinstruccion.required'         => 'Debe ingresar el Nro. de Instrucción',
            'domicilioprocesal.required'         => 'Debe ingresar el domicilio procesal',
            'actafiscalizacion_id.required'         => 'Debe ingresar la Acta de Fiscalizacion',
            'notificacioncargo_id.required'         => 'Debe ingresar la Notificacion de Cargo',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $resolucionsancion = ResolucionSancion::find($id);
            $resolucionsancion->fechaemision                 = $request->fechaemision;
            $resolucionsancion->fechainstruccion                 = $request->fechainstruccion;
            $resolucionsancion->ordenanza            = strtoupper(Libreria::getParam($request->input('ordenanza')));
            $resolucionsancion->numero            = strtoupper(Libreria::getParam($request->input('numero')));
            $resolucionsancion->nroinstruccion            = strtoupper(Libreria::getParam($request->input('nroinstruccion')));
            $resolucionsancion->domicilioprocesal            = strtoupper(Libreria::getParam($request->input('domicilioprocesal')));
            $resolucionsancion->fojas            = strtoupper(Libreria::getParam($request->input('fojas')));
            $resolucionsancion->descargo            = strtoupper(Libreria::getParam($request->input('descargo')));
            $resolucionsancion->conclusion            = strtoupper(Libreria::getParam($request->input('conclusion')));
            $resolucionsancion->medidacorrectiva            = strtoupper(Libreria::getParam($request->input('medidacorrectiva')));
            $resolucionsancion->periodo            = strtoupper(Libreria::getParam($request->input('periodo')));
            $resolucionsancion->actafiscalizacion_id            = strtoupper(Libreria::getParam($request->input('actafiscalizacion_id')));
            $resolucionsancion->notificacioncargo_id            = strtoupper(Libreria::getParam($request->input('notificacioncargo_id')));
            $resolucionsancion->save();
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
        $existe = Libreria::verificarExistencia($id, 'resolucionsancion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $resolucionsancion = ResolucionSancion::find($id);
            $resolucionsancion->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'resolucionsancion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = ResolucionSancion::find($id);
        $entidad  = 'resolucionsancion';
        $formData = array('route' => array('resolucionsancion.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'resolucionsancion');
        if ($existe !== true) {
            return $existe;
        }

        $data = ResolucionSancion::find($id);
        $obj = new Enletras();
        $enletras = $obj->ValorEnLetras($data->notificacion->i_monto , 'soles');
        $pdf = PDF::loadView('gestion.pdf.resolucionsancion.pdf', compact('data', 'enletras'))->setPaper('a4', 'portrait');
        $nombre = 'resolucionsancion:' . $data->numero . '-' . $data->fecha . '.pdf';
        return $pdf->stream($nombre);
    } 

    public function generarNumero(Request $request)
    {
        $numerotramite = ResolucionSancion::NumeroSigue();
        echo $numerotramite;
    }
}
