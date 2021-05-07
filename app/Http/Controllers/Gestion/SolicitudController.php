<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Librerias\EnLetras;
use App\Librerias\Libreria;
use App\Models\Gestion\Ordenpago;
use App\Models\Gestion\Solicitud;
use App\Models\Gestion\Tipotramitenodoc;

class SolicitudController extends Controller
{
    protected $folderview      = 'gestion.solicitud';
    protected $tituloAdmin     = 'solicitud';
    protected $tituloRegistrar = 'Registrar Solicitud';
    protected $tituloModificar = 'Modificar Solicitud';
    protected $tituloEliminar  = 'Eliminar Solicitud';
    protected $rutas           = array('create' => 'solicitud.create', 
            'edit'   => 'solicitud.edit', 
            'delete' => 'solicitud.eliminar',
            'search' => 'solicitud.buscar',
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
        $entidad          = 'solicitud';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $contribuyente    = Libreria::getParam($request->input('contribuyente'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = Solicitud::listar($numero, $fecinicio, $fecfin, $contribuyente, $tipo);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI/RUC', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Contribuyente', 'numero' => '1');
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
        $entidad          = 'solicitud';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $tipostramite     = ["" => 'Todos' ] + Tipotramitenodoc::pluck('descripcion' , 'id')->all();
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
        $entidad  = 'solicitud';
        $solicitud = null;
        $toggletipo = null;
        $tipostramite = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $formData = array('solicitud.store');
        $cboOrdenpago = ['' => 'Seleccione una opcion'] + Ordenpago::pluck('numero', 'id')->all();
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('solicitud', 'formData', 'entidad', 'boton', 'listar' ,'tipostramite', 'toggletipo', 'cboOrdenpago'));
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
            'numero' => 'required',
            'tipo' => 'required',
            'fecha' => 'required',
            'contribuyente' => 'required',
            'dni' => 'required',
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar el Número de Solicitud o Expediente',
            'contribuyente.required'         => 'Debe ingresar el Nombre del Contribuyente',
            'dni.required'         => 'Debe ingresar el DNI',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        switch ($request->tipo) {
            case '1':
                break;
            case '2':
                break;
            case '3':
                $reglas = array(
                    'razonsocial' => 'required',
                    'girocomercial' => 'required',
                    'direccion' => 'required',
                    'representante' => 'required',
                    'nombrenegocio' => 'required',
                    'ruc' => 'required',
                    'ordenpago_id'=>'required',
                );
                $mensajes = array(
                    'razonsocial.required'         => 'Debe ingresar la Razón Social',
                    'girocomercial.required'         => 'Debe ingresar el nombre del Giro Comercial',
                    'direccion.required'         => 'Debe ingresar una dirección',
                    'representante.required'         => 'Debe ingresar el Nombre del Representante',
                    'nombrenegocio.required'         => 'Debe ingresar el Nombre del Negocio',
                    'ruc.required'         => 'Debe ingresar el RUC',
                    'ordenpago_id.required'         => 'Debe ingresar el Nro. de Orden de Pago',
                );
                
                break;
            case '4':
                break;
        }

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function() use($request){
                    $solicitud = new Solicitud();
                    $solicitud->numero          = Libreria::getParam($request->input('numero'));
                    $solicitud->tipo_id            = strtoupper(Libreria::getParam($request->input('tipo')));
                    $solicitud->ordenpago_id    = Libreria::getParam($request->input('ordenpago_id'), null);
                    $solicitud->telefono    = Libreria::getParam($request->input('telefono'), null);
                    $solicitud->fecha                 = date("Y-m-d H:i:s");
                    $solicitud->observacion     = strtoupper($request->input('observacion'));
                    $solicitud->contribuyente     = strtoupper($request->input('contribuyente'));
                    $solicitud->nombrenegocio     = strtoupper($request->input('nombrenegocio'));
                    $solicitud->representante     = strtoupper($request->input('representante'));
                    $solicitud->direccion     = strtoupper($request->input('direccion'));
                    $solicitud->razonsocial     = strtoupper($request->input('razonsocial'));
                    $solicitud->girocomercial     = strtoupper($request->input('girocomercial'));
                    $solicitud->dni     = strtoupper($request->input('dni'));
                    $solicitud->ruc     = strtoupper($request->input('ruc'));
                    $solicitud->funcionario          = Libreria::getParam($request->input('funcionario'));
                    $solicitud->solicito          = Libreria::getParam($request->input('solicito'));
                    $solicitud->save();
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
        $existe = Libreria::verificarExistencia($id, 'solicitud');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $solicitud = solicitud::find($id);
        $toggletipo = $solicitud->tipo_id;
        $entidad  = 'solicitud';
        $formData = array('solicitud.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $cboOrdenpago = ['' => 'Seleccione una opcion'] + Ordenpago::pluck('numero', 'id')->all();
        return view($this->folderview.'.mant')->with(compact('solicitud', 'formData', 'entidad', 'boton', 'listar', 'toggletipo', 'cboOrdenpago'));
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
        $existe = Libreria::verificarExistencia($id, 'solicitud');

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
            $solicitud = solicitud::find($id);
            $solicitud->descripcion = strtoupper($request->input('descripcion'));
            $solicitud->save();
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
        $existe = Libreria::verificarExistencia($id, 'solicitud');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $solicitud = solicitud::find($id);
            $solicitud->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'solicitud');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = solicitud::find($id);
        $entidad  = 'solicitud';
        $formData = array('route' => array('solicitud.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'solicitud');
        if ($existe !== true) {
            return $existe;
        }
        $solicitud = Solicitud::with('ordenpago')->find($id);
        $tipo = $solicitud->tipo_id;
        $data = $solicitud;
        switch ($tipo) {
            case '1':
                //$pdf = PDF::loadView('gestion.pdf.solicitud.licenciayautorizacion.licencia', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '2':
                break;
            case '3':
                $pdf = PDF::loadView('gestion.pdf.solicitud.salubridad', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '4':
                break;
        }
        $nombre = 'solicitud:' . $solicitud->numero . '-' . $solicitud->fecha . '.pdf';
        return $pdf->stream($nombre);
    }

    public function generarNumero(Request $request)
    {
        $tipo          = $request->input('tipo');

        $numerotramite = Solicitud::NumeroSigue($tipo);
        echo $numerotramite;
    }
}
