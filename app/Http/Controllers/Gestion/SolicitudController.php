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
        $cabecera[]       = array('valor' => 'Solicitante', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI/RUC', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Dirección', 'numero' => '1');
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
            'tiposolicitud' => 'required',
            'tipotramitesolicitud' => 'required',
            'nombresolicitante' => 'required',
            'dni' => 'required',
            'direccion' => 'required',
            'requisitos' => 'required',
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar el Número de Solicitud',
            'dni.required'         => 'Debe ingresar el Número de DNI',
            'nombresolicitante.required'         => 'Debe ingresar el nombre del solicitante',
            'direccion.required'         => 'Debe ingresar la direccion',
            'requisitos.required'         => 'Debe ingresar los documentos anexos',
            'tiposolicitud.required'         => 'Debe ingresar el tipo de solicitud Definitiva/Temporal',
            'tipotramitesolicitud.required'         => 'Debe de ingresar el tipo de tramite que solicita',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function() use($request){
                    $solicitud = new Solicitud();
                    $solicitud->numero          = Libreria::getParam($request->input('numero'));
                    $solicitud->fecha          =   date("Y-m-d H:i:s");
                    $solicitud->tiposolicitud            = strtoupper(Libreria::getParam($request->input('tiposolicitud')));
                    $solicitud->dni            = strtoupper(Libreria::getParam($request->input('dni')));
                    $solicitud->ruc            = strtoupper(Libreria::getParam($request->input('ruc')));
                    $solicitud->razonsocial            = strtoupper(Libreria::getParam($request->input('razonsocial')));
                    $solicitud->direccion            = strtoupper(Libreria::getParam($request->input('direccion')));
                    $solicitud->numerocasa            = strtoupper(Libreria::getParam($request->input('numerocasa')));
                    $solicitud->manzanacasa            = strtoupper(Libreria::getParam($request->input('manzanacasa')));
                    $solicitud->lotecasa            = strtoupper(Libreria::getParam($request->input('lotecasa')));
                    $solicitud->urbanizacion            = strtoupper(Libreria::getParam($request->input('urbanizacion')));
                    $solicitud->representantelegal            = strtoupper(Libreria::getParam($request->input('representantelegal')));
                    $solicitud->dnirepresentante            = strtoupper(Libreria::getParam($request->input('dnirepresentante')));
                    $solicitud->rucrepresentante            = strtoupper(Libreria::getParam($request->input('rucrepresentante')));
                    $solicitud->telefonorepresentante            = strtoupper(Libreria::getParam($request->input('telefonorepresentante')));
                    $solicitud->nombrenegocio            = strtoupper(Libreria::getParam($request->input('nombrenegocio')));
                    $solicitud->girocomercial            = strtoupper(Libreria::getParam($request->input('girocomercial')));
                    $solicitud->area            = strtoupper(Libreria::getParam($request->input('area'), 0));
                    $solicitud->requisitos            = implode('===',$request->input('requisitos'));
                    $solicitud->tipotramitesolicitud            = implode('-',$request->input('tipotramitesolicitud'));
                    $solicitud->publicidadexterior            = strtoupper(Libreria::getParam($request->input('publicidadexterior')));
                    $solicitud->colores            = strtoupper(Libreria::getParam($request->input('colores')));
                    $solicitud->tipoanuncio            = strtoupper(Libreria::getParam($request->input('tipoanuncio')));
                    $solicitud->medidas            = strtoupper(Libreria::getParam($request->input('medidas')));
                    $solicitud->leyendas            = strtoupper(Libreria::getParam($request->input('leyendas')));
                    $solicitud->materiales            = strtoupper(Libreria::getParam($request->input('materiales')));
                    $solicitud->cantidadanuncios            = Libreria::getParam($request->input('cantidadanuncios'), null);
                    $solicitud->nroexpediente            = strtoupper(Libreria::getParam($request->input('nroexpediente')));
                    $solicitud->nrocertificado            = strtoupper(Libreria::getParam($request->input('nrocertificado')));
                    $solicitud->nroresolucion            = strtoupper(Libreria::getParam($request->input('nroresolucion')));
                    $solicitud->nombresolicitante    = Libreria::getParam($request->input('nombresolicitante'), null);
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
        $solicitud = Solicitud::find($id);
        $toggletipo = $solicitud->tipo_id;
        $entidad  = 'solicitud';
        $formData = array('solicitud.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('solicitud', 'formData', 'entidad', 'boton', 'listar', 'toggletipo'));
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
        $reglas     = array(
            'numero' => 'required',
            'tiposolicitud' => 'required',
            'tipotramitesolicitud' => 'required',
            'nombresolicitante' => 'required',
            'dni' => 'required',
            'direccion' => 'required',
            'requisitos' => 'required',
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar el Número de Solicitud',
            'dni.required'         => 'Debe ingresar el Número de DNI',
            'nombresolicitante.required'         => 'Debe ingresar el nombre del solicitante',
            'direccion.required'         => 'Debe ingresar la direccion',
            'requisitos.required'         => 'Debe ingresar los documentos anexos',
            'tiposolicitud.required'         => 'Debe ingresar el tipo de solicitud Definitiva/Temporal',
            'tipotramitesolicitud.required'         => 'Debe de ingresar el tipo de tramite que solicita',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $solicitud = Solicitud::find($id);
            $solicitud->numero          = Libreria::getParam($request->input('numero'));
            $solicitud->dni            = strtoupper(Libreria::getParam($request->input('dni')));
            $solicitud->tiposolicitud            = strtoupper(Libreria::getParam($request->input('tiposolicitud')));
            $solicitud->razonsocial            = strtoupper(Libreria::getParam($request->input('razonsocial')));
            $solicitud->ruc            = strtoupper(Libreria::getParam($request->input('ruc')));
            $solicitud->numerocasa            = strtoupper(Libreria::getParam($request->input('numerocasa')));
            $solicitud->direccion            = strtoupper(Libreria::getParam($request->input('direccion')));
            $solicitud->lotecasa            = strtoupper(Libreria::getParam($request->input('lotecasa')));
            $solicitud->manzanacasa            = strtoupper(Libreria::getParam($request->input('manzanacasa')));
            $solicitud->representantelegal            = strtoupper(Libreria::getParam($request->input('representantelegal')));
            $solicitud->urbanizacion            = strtoupper(Libreria::getParam($request->input('urbanizacion')));
            $solicitud->rucrepresentante            = strtoupper(Libreria::getParam($request->input('rucrepresentante')));
            $solicitud->dnirepresentante            = strtoupper(Libreria::getParam($request->input('dnirepresentante')));
            $solicitud->nombrenegocio            = strtoupper(Libreria::getParam($request->input('nombrenegocio')));
            $solicitud->telefonorepresentante            = strtoupper(Libreria::getParam($request->input('telefonorepresentante')));
            $solicitud->girocomercial            = strtoupper(Libreria::getParam($request->input('girocomercial')));
            $solicitud->area            = Libreria::getParam($request->input('area'), 0);
            $solicitud->requisitos            = implode('-',$request->input('requisitos'));
            $solicitud->tipotramitesolicitud            = implode('-',$request->input('tipotramitesolicitud'));
            $solicitud->publicidadexterior            = strtoupper(Libreria::getParam($request->input('publicidadexterior')));
            $solicitud->colores            = strtoupper(Libreria::getParam($request->input('colores')));
            $solicitud->tipoanuncio            = strtoupper(Libreria::getParam($request->input('tipoanuncio')));
            $solicitud->medidas            = strtoupper(Libreria::getParam($request->input('medidas')));
            $solicitud->leyendas            = strtoupper(Libreria::getParam($request->input('leyendas')));
            $solicitud->materiales            = strtoupper(Libreria::getParam($request->input('materiales')));
            $solicitud->cantidadanuncios            = strtoupper(Libreria::getParam($request->input('cantidadanuncios')));
            $solicitud->nroexpediente            = strtoupper(Libreria::getParam($request->input('nroexpediente')));
            $solicitud->nrocertificado            = strtoupper(Libreria::getParam($request->input('nrocertificado')));
            $solicitud->nroresolucion            = strtoupper(Libreria::getParam($request->input('nroresolucion')));
            $solicitud->nombresolicitante    = Libreria::getParam($request->input('nombresolicitante'), null);
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
            $solicitud = Solicitud::find($id);
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
        $modelo   = Solicitud::find($id);
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
        $solicitud = Solicitud::find($id);
        $data = $solicitud;
        $pdf = PDF::loadView('gestion.pdf.solicitud.licencias', compact('data'))->setPaper('a4', 'portrait');
        $nombre = 'solicitud:' . $solicitud->numero . '-' . $solicitud->fecha . '.pdf';
        return $pdf->stream($nombre);
    }

    public function generarNumero(Request $request)
    {
        $year = date('Y');
        $numerotramite = Solicitud::NumeroSigue();
        echo $year .'-'.$numerotramite;
    }
}
