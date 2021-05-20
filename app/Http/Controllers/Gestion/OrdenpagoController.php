<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Gestion\Ordenpago;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Librerias\EnLetras;
use App\Models\Control\Subtipotramitenodoc;
use App\Models\Gestion\Tipotramitenodoc;
use App\Models\Gestion\Tramite;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use GuzzleHttp\Client;


class OrdenpagoController extends Controller
{
    protected $folderview      = 'gestion.ordenpago';
    protected $tituloAdmin     = 'Ordenpago';
    protected $tituloRegistrar = 'Registrar Orden pago';
    protected $tituloModificar = 'Modificar Orden pago';
    protected $tituloEliminar  = 'Eliminar Orden pago';
    protected $rutas           = array('create' => 'ordenpago.create', 
            'edit'   => 'ordenpago.edit', 
            'delete' => 'ordenpago.eliminar',
            'search' => 'ordenpago.buscar',
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
        $entidad          = 'ordenpago';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $contribuyente    = Libreria::getParam($request->input('contribuyente'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $subtipo             = Libreria::getParam($request->input('subtipo'));
        $estado             = Libreria::getParam($request->input('estado'));
        $resultado        = Ordenpago::listar($numero, $fecinicio, $fecfin, $contribuyente, $tipo , $subtipo , $estado);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Subtipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI/RUC', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Monto', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Archivo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
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
        $entidad          = 'ordenpago';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $tipostramite     = ["" => 'Todos' ] + Tipotramitenodoc::pluck('descripcion' , 'id')->all();
        $subtipostramite     = ["" => 'Todos' ] + Subtipotramitenodoc::pluck('descripcion' , 'id')->all();
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta' , 'tipostramite' , 'subtipostramite'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'ordenpago';
        $ordenpago = null;
        $tipostramite = ["" => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $subtipos = null;
        $formData = array('ordenpago.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('ordenpago', 'formData', 'entidad', 'boton', 'listar' ,'tipostramite','subtipos'));
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
            'tipotramite' => 'required',
            'monto' => 'required|numeric',
            'dni_ruc' => 'required',
            'contribuyente' => 'required',
            'fecha' => 'required',
            'estado' => 'required',
            'numerooperacion' => 'required_if:estado,==,confirmado',
            'fechaoperacion' => 'required_if:estado,==,confirmado',
            // 'tramiteref' => 'required_if:estado,==,confirmado',
        );
        $mensajes = array(
            'contribuyente.required'         => 'Debe ingresar el nombre del contribuyente'
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $ordenpago = new Ordenpago();
            $ordenpago->numero          = Libreria::getParam($request->input('numero'));
            $ordenpago->codigopago          = Libreria::getParam($request->input('codigopago'));
            $ordenpago->tipo_id            = Libreria::getParam($request->input('tipotramite'));
            $ordenpago->subtipo_id          = Libreria::getParam($request->input('subtipotramite'));
            $ordenpago->dni_ruc         = Libreria::getParam($request->input('dni_ruc'));
            $ordenpago->contribuyente   = Libreria::getParam($request->input('contribuyente'));
            $ordenpago->direccion       = Libreria::getParam($request->input('direccion'));
            $ordenpago->fecha           = $request->input('fecha');
            $ordenpago->monto           = $request->input('monto');
            
            $ordenpago->representante   = strtoupper($request->input('representante'));
            $ordenpago->descripcion     = strtoupper($request->input('descripcion'));
            $ordenpago->estado          = $request->input('estado');
            
            if($ordenpago->estado == 'confirmado'){
                $ordenpago->tramiteref_id  = Libreria::getParam($request->input('tramiteref'));
                $ordenpago->numerooperacion  = $request->input('numerooperacion');
                $ordenpago->fechaoperacion      = $request->input('fechaoperacion');
                $ordenpago->cuenta      = $request->input('cuenta');
                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $nombre =  time().'.'.$extension;
                    \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                    // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                    $ordenpago->imagen = $nombre;
                }
            }
            $ordenpago->save();
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
        $existe = Libreria::verificarExistencia($id, 'ordenpago');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $ordenpago = Ordenpago::find($id);
        $entidad  = 'ordenpago';
        $formData = array('ordenpago.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $tramites = ["" => 'Seleccione'] +Tramite::pluck('numero', 'id')->all();
        $tipostramite = ["" => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $subtipos =["" => 'Seleccione'] + Subtipotramitenodoc::where('tipotramitenodoc_id', $ordenpago->tipo_id)->pluck('descripcion','id')->all();
        return view($this->folderview.'.mant')->with(compact('ordenpago', 'formData', 'entidad', 'boton', 'listar','tipostramite','subtipos','tramites'));
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
        $existe = Libreria::verificarExistencia($id, 'ordenpago');

        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'numero' => 'required',
            'tipotramite' => 'required',
            'monto' => 'required|numeric',
            'dni_ruc' => 'required',
            'contribuyente' => 'required',
            'fecha' => 'required',
            'estado' => 'required',
            'numerooperacion' => 'required_if:estado,==,confirmado',
            'fechaoperacion' => 'required_if:estado,==,confirmado',
            // 'tramiteref' => 'required_if:estado,==,confirmado',
        );
        $mensajes = array(
            'contribuyente.required'         => 'Debe ingresar el nombre del contribuyente'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $ordenpago = Ordenpago::find($id);
            $ordenpago->numero          = Libreria::getParam($request->input('numero'));
            $ordenpago->codigopago          = Libreria::getParam($request->input('codigopago'));
            $ordenpago->tipo_id            = Libreria::getParam($request->input('tipotramite'));
            $ordenpago->subtipo_id          = Libreria::getParam($request->input('subtipotramite'));
            $ordenpago->dni_ruc         = Libreria::getParam($request->input('dni_ruc'));
            $ordenpago->contribuyente   = Libreria::getParam($request->input('contribuyente'));
            $ordenpago->direccion       = Libreria::getParam($request->input('direccion'));
            // $ordenpago->fecha           = $request->input('fecha');
            $ordenpago->monto           = $request->input('monto');
            
            $ordenpago->representante   = strtoupper($request->input('representante'));
            $ordenpago->descripcion     = strtoupper($request->input('descripcion'));
            $ordenpago->estado          = $request->input('estado');
            
            if($ordenpago->estado == 'confirmado'){
                $ordenpago->tramiteref_id  = Libreria::getParam($request->input('tramiteref'));
                $ordenpago->numerooperacion  = $request->input('numerooperacion');
                $ordenpago->fechaoperacion      = $request->input('fechaoperacion');
                $ordenpago->cuenta      = $request->input('cuenta');
                if($request->hasFile('file')){
                    $file = $request->file('file');
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $nombre =  time().'.'.$extension;
                    \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                    // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                    $ordenpago->imagen = $nombre;
                }
            }
            $ordenpago->save();
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
        $existe = Libreria::verificarExistencia($id, 'ordenpago');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $ordenpago = Ordenpago::find($id);
            $ordenpago->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'ordenpago');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Ordenpago::find($id);
        $entidad  = 'ordenpago';
        $formData = array('route' => array('ordenpago.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'ordenpago');
        if ($existe !== true) {
            return $existe;
        }

        $ordenpago = Ordenpago::find($id);
        $obj = new Enletras();
        $enletras = $obj->ValorEnLetras($ordenpago->monto , 'soles');

        $pdf = PDF::loadView($this->folderview.'.pdf' , compact('ordenpago'  , 'enletras'))->setPaper('a4','landscape');
        //HOJA HORIZONTAL ->setPaper('a4', 'landscape')
    //descargar
       // return $pdf->download('F'.$cotizacion->documento->correlativo.'.pdf');  
    //Ver
       return $pdf->stream('ordenpago.pdf');
    }

    public function generarNumero(Request $request)
    {
        $tipo          = $request->input('tipotramite');

        $numerotramite = Ordenpago::NumeroSigue($tipo);
        echo $numerotramite;
    }

    public function buscarDNI(Request $request)
    {
        $respuesta = array();
        $dni = $request->input('dni');
        $client = new Client();
        $res = $client->get('http://facturae-garzasoft.com/facturacion/buscaCliente/BuscaCliente2.php?' . 'dni=' . $dni . '&fe=N&token=qusEj_w7aHEpX');
        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
            $respuesta = json_decode($response_data);
        }
        return json_encode($respuesta);
    }

    public function buscarRUC(Request $request)
    {
        $respuesta = array();
        $ruc = $request->input('ruc');
        $client = new Client();
        $res = $client->get('http://157.245.85.164/facturacion/buscaCliente/BuscaClienteRuc.php?fe=N&token=qusEj_w7aHEpX&' . 'ruc=' . $ruc);
        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
            $respuesta = json_decode($response_data);
        }
        return json_encode($respuesta);
    }
}
