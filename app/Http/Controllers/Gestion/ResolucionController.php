<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Gestion\Inspeccion;
use App\Models\Gestion\Ordenpago;
use App\Models\Gestion\Resolucion;
use App\Models\Gestion\Tipotramitenodoc;
use Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;



class ResolucionController extends Controller
{
    protected $folderview      = 'gestion.resolucion';
    protected $tituloAdmin     = 'Resolución';
    protected $tituloRegistrar = 'Registrar Resolución';
    protected $tituloModificar = 'Modificar Resolución';
    protected $tituloEliminar  = 'Eliminar Resolución';
    protected $rutas           = array(
        'create' => 'resolucion.create',
        'edit'   => 'resolucion.edit',
        'delete' => 'resolucion.eliminar',
        'search' => 'resolucion.buscar',
        'index'  => 'resolucion.index',
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
        $entidad          = 'resolucion';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $contribuyente    = Libreria::getParam($request->input('contribuyente'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = Resolucion::with('ordenpago', 'inspeccion', 'tipotramite')->listar($numero, $fecinicio, $fecfin, $contribuyente, $tipo);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Contribuyente', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI/RUC', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro. Orden de Pago', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro. de de Inspeccion', 'numero' => '1');
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
            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview . '.list')->with(compact('lista', 'entidad'));
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad          = 'resolucion';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $tipostramite = ['' => 'TODOS'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'tipostramite'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'resolucion';
        $resolucion = null;
        $formData = array('resolucion.store');
        $tipostramite = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $toggletipo = null;
        $cboInspeccion = ['' => 'Seleccione una opcion'] + Inspeccion::pluck('numero', 'id')->all();
        $cboOrdenpago = ['' => 'Seleccione una opcion'] + Ordenpago::pluck('numero', 'id')->all();
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        return view($this->folderview . '.mant')->with(compact('resolucion', 'formData', 'entidad', 'boton', 'listar', 'tipostramite', 'cboInspeccion', 'cboOrdenpago', 'toggletipo'));
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
            'contribuyente' => 'required',
            'tipo' => 'required',
            'fechavencimiento'         => 'required',
            'direccion'         => 'required',
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar un numero',
            'contribuyente.required'         => 'Debe ingresar el nombre del Propietario',
            'tipo.required'         => 'Debe ingresar el tipo',
            'fechavencimiento.required'         => 'Debe ingresar la Fecha de Vencimiento',
            'direccion.required'         => 'Debe ingresar una direccion/ubicación',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        switch ($request->tipo) {
            case '1':
                $reglas     = array(
                    'funcionamiento' => 'required',
                    'nombrecomercial' => 'required',
                    'nroexpediente' => 'required',
                    'viapublica' => 'required',
                    'arearesolucion' => 'required',
                );
                $mensajes = array(
                    'nroexpediente.required'         => 'Debe ingresar el Nro. de Expediente',
                    'nombrecomercial.required'         => 'Debe ingresar el Nombre Comercial del Negocio',
                    'viapublica.required'         => 'Debe especificar si usa la vía pública',
                    'funcionamiento.required'         => 'Debe ingresar el tipo de funcionamiento',
                    'arearesolucion.required'         => 'Debe ingresar el área',
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function () use ($request) {
                    $resolucion = Resolucion::create([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observaciones' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'area' => $request->input('arearesolucion'),           
                        'numero'=>$request->input('numero'),     
                        'nroexpediente'=>strtoupper($request->input('nroexpediente')),     
                        'nrocertificado'=>strtoupper($request->input('nrocertificado')),     
                        'nombrecomercial'=>strtoupper($request->input('nombrecomercial')),     
                        'viapublica'=>strtoupper($request->input('viapublica')),     
                        'funcionamiento'=>strtoupper($request->input('funcionamiento')),     
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
            case '2':
                $reglas     = array(
                    'proyecto' => 'required',
                    'uso' => 'required',
                    'zona' => 'required',
                    'altura' => 'required',
                    'area' => 'required',
                    'valor' => 'required',
                    'responsableobra' => 'required',
                    'ordenpago_id'=>'required'
                );
                $mensajes = array(
                    'uso.required'         => 'Debe ingresar un uso',
                    'zona.required'         => 'Debe ingresar el nombre de la Zonificación',
                    'proyecto.required'         => 'Debe ingresar la proyecto',
                    'altura.required'         => 'Debe ingresar la altura',
                    'area.required'         => 'Debe ingresar el área',
                    'valor.required'         => 'Debe ingresar el Valor de la Obra',
                    'responsableobra.required'         => 'Debe ingresar el Nombre del Responsable de la Obra',
                    'ordenpago_id.required' => 'Debe Ingresar el Nro. de Orden de Pago'
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function () use ($request) {
                    $resolucion = Resolucion::create([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observaciones' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'zona' => strtoupper(Libreria::getParam($request->input('zona'))),                
                        'altura' => strtoupper(Libreria::getParam($request->input('altura'))),                
                        'uso' => strtoupper(Libreria::getParam($request->input('uso'))),                
                        'proyecto' => strtoupper(Libreria::getParam($request->input('proyecto'))),                
                        'responsableobra' => strtoupper(Libreria::getParam($request->input('responsableobra'))), 
                        'area' => $request->input('area'),           
                        'valor' => $request->input('valor'),           
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'numero'=>$request->input('numero'),     
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
            case '3':
                $reglas     = array(
                    'localidad' => 'required',
                    'categoria' => 'required',
                    'zona' => 'required',
                    'razonsocial' => 'required',
                    'girocomercial' => 'required',
                );
                $mensajes = array(
                    'categoria.required'         => 'Debe ingresar una categoria',
                    'zona.required'         => 'Debe ingresar el nombre de la zona',
                    'localidad.required'         => 'Debe ingresar la localidad',
                    'razonsocial.required'         => 'Debe ingresar la Razón Social',
                    'girocomercial.required'         => 'Debe ingresar el nombre del Giro Comercial',
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function () use ($request) {
                    $resolucion = Resolucion::create([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observaciones' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),                
                        'localidad' => strtoupper(Libreria::getParam($request->input('localidad'))),                
                        'zona' => strtoupper(Libreria::getParam($request->input('zona'))),                
                        'categoria' => strtoupper(Libreria::getParam($request->input('categoria'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'numero'=>$request->input('numero'),     
                    ]);
                });
                return is_null($error) ? "OK" : $error;
                break;
            case '4':
                $error = DB::transaction(function () use ($request) {
                    $resolucion = Resolucion::create([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observacion' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'numero'=>$request->input('numero'),     
                        'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),  
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
        }
        /* $error = DB::transaction(function () use ($request) {
            $resolucion = Resolucion::create([
                'fecha' => $request->input('fecha'),           
                'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                'observacion' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                'dni' => Libreria::getParam($request->input('dni')),           
                'ruc' => Libreria::getParam($request->input('ruc')),           
                'ordenpago_id' => $request->input('ordenpago_id'),       
                'inspeccion_id' => $request->input('inspeccion_id'), 
                'tipo'=>$request->input('tipo'),     
                'numero'=>$request->input('numero'),     
            ]);
            
        });
        return is_null($error) ? "OK" : $error; */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $resolucion = Resolucion::find($id);
        $tipostramite = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $toggletipo = $resolucion->tipo_id;
         
        $cboInspeccion = ['' => 'Seleccione una opcion'] + Inspeccion::pluck('numero', 'id')->all();
        $cboOrdenpago = ['' => 'Seleccione una opcion'] + Ordenpago::pluck('numero', 'id')->all();
        $entidad  = 'resolucion';
        $formData = array('resolucion.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview . '.mant')->with(compact('resolucion', 'formData', 'entidad', 'boton', 'listar', 'tipostramite', 'cboInspeccion', 'cboOrdenpago', 'toggletipo'));
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
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }        
        $reglas     = array(
            'numero' => 'required',
            'contribuyente' => 'required',
            'tipo' => 'required',
            'fechavencimiento'         => 'required',
            'direccion'         => 'required',
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar un numero',
            'contribuyente.required'         => 'Debe ingresar el nombre del Propietario',
            'tipo.required'         => 'Debe ingresar el tipo',
            'fechavencimiento.required'         => 'Debe ingresar la Fecha de Vencimiento',
            'direccion.required'         => 'Debe ingresar una direccion/ubicación',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $resolucion = Resolucion::find($id);

        switch ($request->tipo) {
            case '1':
                $reglas     = array(
                    'funcionamiento' => 'required',
                    'nombrecomercial' => 'required',
                    'nroexpediente' => 'required',
                    'viapublica' => 'required',
                    'arearesolucion' => 'required',
                );
                $mensajes = array(
                    'nroexpediente.required'         => 'Debe ingresar el Nro. de Expediente',
                    'nombrecomercial.required'         => 'Debe ingresar el Nombre Comercial del Negocio',
                    'viapublica.required'         => 'Debe especificar si usa la vía pública',
                    'funcionamiento.required'         => 'Debe ingresar el tipo de funcionamiento',
                    'arearesolucion.required'         => 'Debe ingresar el área',
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function () use ($request, $resolucion) {
                    $resolucion->update([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observaciones' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'area' => $request->input('arearesolucion'),           
                        'numero'=>$request->input('numero'),     
                        'nroexpediente'=>strtoupper($request->input('nroexpediente')),     
                        'nrocertificado'=>strtoupper($request->input('nrocertificado')),     
                        'nombrecomercial'=>strtoupper($request->input('nombrecomercial')),     
                        'viapublica'=>strtoupper($request->input('viapublica')),     
                        'funcionamiento'=>strtoupper($request->input('funcionamiento')),     
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
            case '2':
                $reglas     = array(
                    'proyecto' => 'required',
                    'uso' => 'required',
                    'zonificacion' => 'required',
                    'altura' => 'required',
                    'area' => 'required',
                    'valor' => 'required',
                    'responsableobra' => 'required',
                    'ordenpago_id'=>'required'
                );
                $mensajes = array(
                    'uso.required'         => 'Debe ingresar un uso',
                    'zonificacion.required'         => 'Debe ingresar el nombre de la Zonificación',
                    'proyecto.required'         => 'Debe ingresar la proyecto',
                    'altura.required'         => 'Debe ingresar la altura',
                    'area.required'         => 'Debe ingresar el área',
                    'valor.required'         => 'Debe ingresar el Valor de la Obra',
                    'responsableobra.required'         => 'Debe ingresar el Nombre del Responsable de la Obra',
                    'ordenpago_id.required' => 'Debe Ingresar el Nro. de Orden de Pago'
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function () use ($request, $resolucion) {
                    $resolucion->update([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observaciones' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        //'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        //'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),                
                        //'localidad' => strtoupper(Libreria::getParam($request->input('localidad'))),                
                        'zona' => strtoupper(Libreria::getParam($request->input('zonificacion'))),                
                        'altura' => strtoupper(Libreria::getParam($request->input('altura'))),                
                        'uso' => strtoupper(Libreria::getParam($request->input('uso'))),                
                        'proyecto' => strtoupper(Libreria::getParam($request->input('proyecto'))),                
                        'responsableobra' => strtoupper(Libreria::getParam($request->input('responsableobra'))), 
                        'area' => $request->input('area'),           
                        'valor' => $request->input('valor'),           
                        //'categoria' => strtoupper(Libreria::getParam($request->input('categoria'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'numero'=>$request->input('numero'),     
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
            case '3':
                $reglas     = array(
                    'localidad' => 'required',
                    'categoria' => 'required',
                    'zona' => 'required',
                    'razonsocial' => 'required',
                    'girocomercial' => 'required',
                );
                $mensajes = array(
                    'categoria.required'         => 'Debe ingresar una categoria',
                    'zona.required'         => 'Debe ingresar el nombre de la zona',
                    'localidad.required'         => 'Debe ingresar la localidad',
                    'razonsocial.required'         => 'Debe ingresar la Razón Social',
                    'girocomercial.required'         => 'Debe ingresar el nombre del Giro Comercial',
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function () use ($request, $resolucion) {
                    $resolucion->update([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observaciones' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),                
                        'localidad' => strtoupper(Libreria::getParam($request->input('localidad'))),                
                        'zona' => strtoupper(Libreria::getParam($request->input('zona'))),                
                        'categoria' => strtoupper(Libreria::getParam($request->input('categoria'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'numero'=>$request->input('numero'),     
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
            case '4':
                $error = DB::transaction(function () use ($request) {
                    $resolucion = Resolucion::create([
                        'fechaexpedicion' => $request->input('fechaexpedicion'),           
                        'fechavencimiento' => $request->input('fechavencimiento'),           
                        'contribuyente' => strtoupper(Libreria::getParam($request->input('contribuyente'))),
                        'direccion' => strtoupper(Libreria::getParam($request->input('direccion'))),
                        'observacion' => strtoupper(Libreria::getParam($request->input('observacion'))),                
                        'dni' => Libreria::getParam($request->input('dni')),           
                        'ruc' => Libreria::getParam($request->input('ruc')),           
                        'ordenpago_id' => $request->input('ordenpago_id'),       
                        'inspeccion_id' => $request->input('inspeccion_id'), 
                        'tipo_id'=>$request->input('tipo'),     
                        'numero'=>$request->input('numero'),     
                        'razonsocial' => strtoupper(Libreria::getParam($request->input('razonsocial'))),                
                        'girocomercial' => strtoupper(Libreria::getParam($request->input('girocomercial'))),  
                    ]);
                    
                });
                return is_null($error) ? "OK" : $error;
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function () use ($id) {
            $resolucion = Resolucion::find($id);
            $resolucion->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Resolucion::find($id);
        $entidad  = 'resolucion';
        $formData = array('route' => array('resolucion.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }


    public function pdfResolucion($id, $blanco=null){
        $resolucion = Resolucion::with('ordenpago', 'inspeccion')->find($id);
        $tipo = $resolucion->tipo_id;
        $data = $resolucion;
        switch ($tipo) {
            case '1':
                $pdf = PDF::loadView('gestion.pdf.resolucion.licenciayautorizacion.licencia', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '2':
                $pdf = PDF::loadView('gestion.pdf.resolucion.edificaciones.edificaciones', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '3':
                if(!is_null($blanco)){
                    $pdf = PDF::loadView('gestion.pdf.resolucion.salubridad.salubridad2', compact('data'))->setPaper('a4', 'landscape');
                }else{
                    $pdf = PDF::loadView('gestion.pdf.resolucion.salubridad.salubridad', compact('data'))->setPaper('a4', 'landscape');
                }
                break;
            case '4':
                $pdf = PDF::loadView('gestion.pdf.resolucion.defensacivil.defensa', compact('data'))->setPaper('a4', 'portrait');
                break;
        }
        $nombre = 'Resolucion:' . $resolucion->numero . '-' . $resolucion->fecha . '.pdf';
        return $pdf->stream($nombre);
    }

    public function listarInspeccion(Request $request){
        $q = $request->input('search');
        $tipo = $request->input('tipo');
        if($tipo!='no'){
            $resultados = Inspeccion::where(function($query) use($q, $tipo){
                $query->where('numero','LIKE', '%'.$q.'%')
                     ->where('tipo_id','LIKE' , '%'.$tipo.'%');   
            })->get();
            $data = array();
            foreach ($resultados as $r) {
                $data["results"][] = [ "text" => $r->numero,"id" => $r->id];
            }
            return  \json_encode($data);
        }
        
    }
    public function listarOrdenpago(Request $request){
        $q = $request->input('search');
        $tipo = $request->input('tipo');
        if($tipo!='no'){
            $resultados = Ordenpago::where(function($query) use($q, $tipo){
                $query->where('numero','LIKE', '%'.$q.'%')
                     ->where('tipo_id','LIKE' , '%'.$tipo.'%');   
            })->get();
            $data = array();
            foreach ($resultados as $r) {
                $data["results"][] = [ "text" => $r->numero,"id" => $r->id];
            }
            return  \json_encode($data);
        }
    }
    public function generarNumero(Request $request)
    {
        $tipo          = $request->input('tipo');
        $numerotramite = Resolucion::NumeroSigue($tipo);
        echo $numerotramite;
    }
}
