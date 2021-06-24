<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Librerias\Libreria;
use App\Models\PadronFiscalizacion;
use Illuminate\Support\Facades\Storage;


class PadronFiscalizacionController extends Controller
{
    protected $folderview      = 'gestion.padronfiscalizacion';
    protected $tituloAdmin     = 'padronfiscalizacion';
    protected $tituloRegistrar = 'Registrar Formato de Fiscalización';
    protected $tituloModificar = 'Modificar Formato de Fiscalización';
    protected $tituloEliminar  = 'Eliminar Formato de Fiscalización';
    protected $rutas           = array(
            'create' => 'padronfiscalizacion.create', 
            'edit'   => 'padronfiscalizacion.edit', 
            'delete' => 'padronfiscalizacion.eliminar',
            'search' => 'padronfiscalizacion.buscar',
            'confirmacion'=>'padronfiscalizacion.confirmacion',
            'accion'=>'padronfiscalizacion.accion',
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
        $entidad          = 'padronfiscalizacion';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $contribuyente    = Libreria::getParam($request->input('contribuyente'));
       // $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = PadronFiscalizacion::listar($numero, $fecinicio, $fecfin, $contribuyente);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Razon Social', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Representante', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Direccion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Rubro', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Archivo', 'numero' => '1');
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
        $entidad          = 'padronfiscalizacion';
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
        $entidad  = 'padronfiscalizacion';
        $padronfiscalizacion = null;     
        $cboTamanos = [''=>'Seleccione una Opción'] + ['PEQUENA EMPRESA'=>'Pequeña Empresa: De 1 a 10 Trabajadores', 'MYPE'=>'MYPE: De 10 a 100 Trabajadores', 'GRANDE EMPRESA'=>'Grande Empresa: De 100 a 1000 Trabajadores'];
        $cboCondiciones = [''=>'Seleccione una Opción'] + ['LOCAL PROPIO'=>'LOCAL PROPIO', 'LOCAL ALQUILADO'=>'LOCAL ALQUILADO'];
        $formData = array('padronfiscalizacion.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('padronfiscalizacion', 'formData', 'entidad', 'boton', 'listar', 'cboTamanos', 'cboCondiciones'));
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
            'fecha' => 'required',
            'numero' => 'required',
            'fiscalizador' => 'required',
            //'archivo' => 'required',
            'rubro' => 'required',
            'representantelegal' => 'required',
            'tamano' => 'required',
            'condicion' => 'required',


        );
        $mensajes = array(
            'fecha.required'         => 'Debe ingresar la fecha',
            'numero.required'         => 'Debe ingresar el numero',
            'fiscalizador.required'         => 'Debe ingresar el Nombre del Responsable del llenado del formato',
            'representantelegal.required'         => 'Debe ingresar el nombre del Rep. Legal',
            'tamano.required'         => 'Debe ingresar el tamaño de la empresa',
            'rubro.required'         => 'Debe ingresar el rubro',
            'archivo.required'         => 'Debe ingresar el archivo',
            'condicion.required'         => 'Debe ingresar la condicion del establecimiento',
        );

            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $formalizacion = implode('-', $request->formalizacion);
        if(str_contains($formalizacion, 'OTROS')){
            $formalizacion = $formalizacion . '-' . strtoupper(Libreria::getParam($request->input('otrostxt')));
        }
        $error = DB::transaction(function() use($request, $formalizacion){
            $padronfiscalizacion = new PadronFiscalizacion();
            $padronfiscalizacion->fecha                 = $request->fecha;
            $padronfiscalizacion->vigencia1             = $request->desde1 . '/' . $request->hasta1 . '/' . $request->entramite1 ;
            $padronfiscalizacion->vigencia2             = $request->desde2 . '/' . $request->hasta2 . '/' . $request->entramite2 ;
            $padronfiscalizacion->vigencia3             = $request->desde3 . '/' . $request->hasta3 . '/' . $request->entramite3 ;
            $padronfiscalizacion->vigencia4             = $request->desde4 . '/' . $request->hasta4 . '/' . $request->entramite4 ;
            $padronfiscalizacion->vigencia5             = $request->desde5 . '/' . $request->hasta5 . '/' . $request->entramite5 ;
            $padronfiscalizacion->numero                = $request->numero;
            $padronfiscalizacion->formalizacion         = $formalizacion;
            $padronfiscalizacion->alpropietario         =($request->alpropietario) ? implode('-', $request->alpropietario) : null;
            $padronfiscalizacion->fiscalizador          = strtoupper(Libreria::getParam($request->input('fiscalizador')));
            $padronfiscalizacion->ruc                   = strtoupper(Libreria::getParam($request->input('ruc')));
            $padronfiscalizacion->razonsocial           = strtoupper(Libreria::getParam($request->input('razonsocial')));
            $padronfiscalizacion->rubro                 = strtoupper(Libreria::getParam($request->input('rubro')));
            $padronfiscalizacion->representantelegal    = strtoupper(Libreria::getParam($request->input('representantelegal')));
            $padronfiscalizacion->tipopersona            = strtoupper(Libreria::getParam($request->input('tipopersona')));
            $padronfiscalizacion->telefono            = strtoupper(Libreria::getParam($request->input('telefono')));
            $padronfiscalizacion->correo            = Libreria::getParam($request->input('correo'));
            $padronfiscalizacion->direccion            = strtoupper(Libreria::getParam($request->input('direccion')));
            $padronfiscalizacion->urbanizacion            = strtoupper(Libreria::getParam($request->input('urbanizacion')));
            $padronfiscalizacion->sector            = strtoupper(Libreria::getParam($request->input('sector')));
            $padronfiscalizacion->manzana            = strtoupper(Libreria::getParam($request->input('manzana')));
            $padronfiscalizacion->lote            = strtoupper(Libreria::getParam($request->input('lote')));
            $padronfiscalizacion->tamano            = strtoupper(Libreria::getParam($request->input('tamano')));
            $padronfiscalizacion->condicion            = strtoupper(Libreria::getParam($request->input('condicion')));
            $padronfiscalizacion->tipoanuncio            = strtoupper(Libreria::getParam($request->input('tipoanuncio')));
            $padronfiscalizacion->tamanoanuncio            = strtoupper(Libreria::getParam($request->input('tamanoanuncio')));
            $padronfiscalizacion->observaciones            = strtoupper(Libreria::getParam($request->input('observaciones')));
            if($request->hasFile('file')){
                $file = $request->file('file');
                $extension = $request->file('file')->getClientOriginalExtension();
                $nombre =  time().'.'.$extension;
                \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                $padronfiscalizacion->archivo = $nombre;
            }
            $padronfiscalizacion->save();
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
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $padronfiscalizacion = PadronFiscalizacion::find($id);
        $entidad  = 'padronfiscalizacion';
        $cboTamanos = [''=>'Seleccione una Opción'] + ['PEQUENA EMPRESA'=>'Pequeña Empresa: De 1 a 10 Trabajadores', 'MYPE'=>'MYPE: De 10 a 100 Trabajadores', 'GRANDE EMPRESA'=>'Grande Empresa: De 100 a 1000 Trabajadores'];
        $cboCondiciones = [''=>'Seleccione una Opción'] + ['LOCAL PROPIO'=>'LOCAL PROPIO', 'LOCAL ALQUILADO'=>'LOCAL ALQUILADO'];
        $formData = array('padronfiscalizacion.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('cboTamanos', 'cboCondiciones','padronfiscalizacion', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'fecha' => 'required',
            'numero' => 'required',
            'fiscalizador' => 'required',
            //'archivo' => 'required',
            'rubro' => 'required',
            'representantelegal' => 'required',
            'tamano' => 'required',
            'condicion' => 'required',


        );
        $mensajes = array(
            'fecha.required'         => 'Debe ingresar la fecha',
            'numero.required'         => 'Debe ingresar el numero',
            'fiscalizador.required'         => 'Debe ingresar el Nombre del Responsable del llenado del formato',
            'representantelegal.required'         => 'Debe ingresar el nombre del Rep. Legal',
            'tamano.required'         => 'Debe ingresar el tamaño de la empresa',
            'rubro.required'         => 'Debe ingresar el rubro',
            'archivo.required'         => 'Debe ingresar el archivo',
            'condicion.required'         => 'Debe ingresar la condicion del establecimiento',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $formalizacion = implode('-', $request->formalizacion);
        if(str_contains($formalizacion, 'OTROS')){
            $formalizacion = $formalizacion . '-' . strtoupper(Libreria::getParam($request->input('otrostxt')));
        }
        $error = DB::transaction(function() use($request, $id, $formalizacion){
            $padronfiscalizacion = PadronFiscalizacion::find($id);
            $padronfiscalizacion->fecha                 = $request->fecha;
            $padronfiscalizacion->vigencia1             = $request->desde1 . '/' . $request->hasta1 . '/' . $request->entramite1 ;
            $padronfiscalizacion->vigencia2             = $request->desde2 . '/' . $request->hasta2 . '/' . $request->entramite2 ;
            $padronfiscalizacion->vigencia3             = $request->desde3 . '/' . $request->hasta3 . '/' . $request->entramite3 ;
            $padronfiscalizacion->vigencia4             = $request->desde4 . '/' . $request->hasta4 . '/' . $request->entramite4 ;
            $padronfiscalizacion->vigencia5             = $request->desde5 . '/' . $request->hasta5 . '/' . $request->entramite5 ;
            $padronfiscalizacion->numero                = $request->numero;
            $padronfiscalizacion->formalizacion         = $formalizacion;
            $padronfiscalizacion->alpropietario         =($request->alpropietario) ? implode('-', $request->alpropietario) : null;
            $padronfiscalizacion->fiscalizador          = strtoupper(Libreria::getParam($request->input('fiscalizador')));
            $padronfiscalizacion->ruc                   = strtoupper(Libreria::getParam($request->input('ruc')));
            $padronfiscalizacion->razonsocial           = strtoupper(Libreria::getParam($request->input('razonsocial')));
            $padronfiscalizacion->rubro                 = strtoupper(Libreria::getParam($request->input('rubro')));
            $padronfiscalizacion->representantelegal    = strtoupper(Libreria::getParam($request->input('representantelegal')));
            $padronfiscalizacion->tipopersona            = strtoupper(Libreria::getParam($request->input('tipopersona')));
            $padronfiscalizacion->telefono            = strtoupper(Libreria::getParam($request->input('telefono')));
            $padronfiscalizacion->correo            = Libreria::getParam($request->input('correo'));
            $padronfiscalizacion->direccion            = strtoupper(Libreria::getParam($request->input('direccion')));
            $padronfiscalizacion->urbanizacion            = strtoupper(Libreria::getParam($request->input('urbanizacion')));
            $padronfiscalizacion->sector            = strtoupper(Libreria::getParam($request->input('sector')));
            $padronfiscalizacion->manzana            = strtoupper(Libreria::getParam($request->input('manzana')));
            $padronfiscalizacion->lote            = strtoupper(Libreria::getParam($request->input('lote')));
            $padronfiscalizacion->tamano            = strtoupper(Libreria::getParam($request->input('tamano')));
            $padronfiscalizacion->condicion            = strtoupper(Libreria::getParam($request->input('condicion')));
            $padronfiscalizacion->tipoanuncio            = strtoupper(Libreria::getParam($request->input('tipoanuncio')));
            $padronfiscalizacion->tamanoanuncio            = strtoupper(Libreria::getParam($request->input('tamanoanuncio')));
            $padronfiscalizacion->observaciones            = strtoupper(Libreria::getParam($request->input('observaciones')));
            if($request->hasFile('file')){
                $file = $request->file('file');
                $extension = $request->file('file')->getClientOriginalExtension();
                $nombre =  time().'.'.$extension;
                \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                $padronfiscalizacion->archivo = $nombre;
            }
            $padronfiscalizacion->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function confirmacion($id, $listarLuego, $accion){
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = padronfiscalizacion::with('seguimientos.personal', 'seguimientos.areas')->find($id);
        $entidad  = 'padronfiscalizacion';
        $formData = array('route' => array('padronfiscalizacion.accion', $id, $accion), 'method' => 'POST', 'enctype'=>'multipart/form-data','class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Aceptar';
        $usuario = session()->get('personal');      
        $area_actual = $usuario['area_id'];
        return view('reusable.confirmarpadronfiscalizacion')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar', 'accion', 'area_actual'));
    }

    public function accion(Request $request, $id, $accion)
    {
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id, $accion, $request){
            $usuario = session()->get('personal');
            $resolucion = padronfiscalizacion::find($id);
            switch ($accion) {
                case 'seguimiento':
                    break;
                case 'comentar':
                    $reglas     = array('observacion'=>'required');
                    $mensajes = array(
                        'observacion.required' => 'Debe ingresar un observacion sobre el archivo',
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }                   
                    $ultimo_seguimiento = Seguimiento::where('padronfiscalizacion_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'COMENTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'padronfiscalizacion_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion'=> Libreria::getParam($request->input('observacion')),
                    ]);
                    break;
                case 'entregar':
                    $ultimo_seguimiento = Seguimiento::where('padronfiscalizacion_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'ENTREGAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'padronfiscalizacion_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                    ]);
                    $fechaactual= date('Y-m-d');
                    $resolucion->estado='ENTREGADO';
                    $resolucion->fechaentrega=$fechaactual;
                    $resolucion->fechafin=date('Y-m-d', strtotime($fechaactual . "+ 15 days"));
                    $resolucion->save();
                    break;
                case 'coactiva':
                    $ultimo_seguimiento = Seguimiento::where('padronfiscalizacion_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'ENVIAR A COACTIVA',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'padronfiscalizacion_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                    ]);
                    $resolucion->estado='COACTIVA';
                    $resolucion->save();
                    break;
                case 'pagar';
                    $ultimo_seguimiento = Seguimiento::where('padronfiscalizacion_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'PAGAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'padronfiscalizacion_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                    ]);
                    $fechaactual= date('Y-m-d');
                    $resolucion->estado='FINALIZADO';
                    $resolucion->fechapago=$fechaactual;
                    $resolucion->montocancelado=$request->montocancelado;
                    $resolucion->save();
                    break;
                case 'archivar';
                $reglas     = array('observacion'=>'required');
                $mensajes = array(
                    'observacion.required' => 'Debe ingresar el motivo',
                );
                $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }                   
                $ultimo_seguimiento = Seguimiento::where('padronfiscalizacion_id', $id)->orderBy('id', 'desc')->first();
                $correlativo_anterior = $ultimo_seguimiento->correlativo;
                $seguimiento=Seguimiento::create([
                    'fecha'=> date("Y-m-d H:i:s"),
                    'accion' => 'ARCHIVAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                    'correlativo' => $correlativo_anterior+1,
                    'correlativo_anterior' => $correlativo_anterior,
                    'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                    'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                    'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                    'padronfiscalizacion_id' => $id,
                    'personal_id' => $usuario['id'],
                    'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                    'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                    'observacion'=> Libreria::getParam($request->input('observacion')),
                ]);
                $fechaactual= date('Y-m-d');
                $resolucion->estado='ARCHIVADO';
                $resolucion->fechaarchivo=$fechaactual;
                $resolucion->save();
                break;

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
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $padronfiscalizacion = padronfiscalizacion::find($id);
            $padronfiscalizacion->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = padronfiscalizacion::find($id);
        $entidad  = 'padronfiscalizacion';
        $formData = array('route' => array('padronfiscalizacion.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'padronfiscalizacion');
        if ($existe !== true) {
            return $existe;
        }

        $data = padronfiscalizacion::find($id);
        $obj = new Enletras();
        $enletras = $obj->ValorEnLetras($data->notificacion->i_monto , 'soles');
        $pdf = PDF::loadView('gestion.pdf.padronfiscalizacion.pdf', compact('data', 'enletras'))->setPaper('a4', 'portrait');
        $nombre = 'padronfiscalizacion:' . $data->numero . '-' . $data->fecha . '.pdf';
        return $pdf->stream($nombre);
    } 

    public function generarNumero(Request $request)
    {
        $numerotramite = PadronFiscalizacion::NumeroSigue();
        echo $numerotramite;
    }
}
