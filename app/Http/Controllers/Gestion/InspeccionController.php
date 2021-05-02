<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Gestion\Inspeccion;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Models\Gestion\Ordenpago;
use App\Models\Gestion\Tipotramitenodoc;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
class InspeccionController extends Controller
{
    protected $folderview      = 'gestion.inspeccion';
    protected $tituloAdmin     = 'Inspeccion';
    protected $tituloRegistrar = 'Registrar Inspeccion';
    protected $tituloModificar = 'Modificar Inspeccion';
    protected $tituloEliminar  = 'Eliminar Inspeccion';
    protected $rutas           = array('create' => 'inspeccion.create', 
            'edit'   => 'inspeccion.edit', 
            'delete' => 'inspeccion.eliminar',
            'search' => 'inspeccion.buscar',
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
        $entidad          = 'inspeccion';
        $numero           = Libreria::getParam($request->input('numero_search'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $contribuyente    = Libreria::getParam($request->input('contribuyente'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = Inspeccion::with('tipotramite')->listar($numero, $fecinicio, $fecfin, $contribuyente, $tipo);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');

        $cabecera[]       = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Archivo', 'numero' => '1');
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
        $entidad          = 'inspeccion';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $tipostramite     = ["" => 'Todos' ] + Tipotramitenodoc::pluck('descripcion' , 'id')->all();
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'tipostramite'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'inspeccion';
        $inspeccion = null;
        $tipostramite = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        
        $toggletipo = null;
        $cboOrdenpago = ['' => 'Seleccione una opcion'] + Ordenpago::pluck('numero', 'id')->all();   
        $formData = array('inspeccion.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad,'enctype'=>'multipart/form-data', 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('inspeccion', 'formData', 'entidad', 'boton', 'listar', 'tipostramite', 'cboOrdenpago', 'toggletipo'));
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
            'fecha' => 'required'
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar el numero'
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        switch ($request->tipo) {
            case 'LICENCIAS DE FUNCIONAMIENTO Y AUTORIZACIONES':
                $reglas     = array(
                    'razonsocial' => 'required',
                    'girocomercial' => 'required',
                    'direccion' => 'required',
                    'observacion' => 'required',
                    'conclusiones' => 'required',
                    'descripcion' => 'required',
                    'representante' => 'required',
                    'dni' => 'required',
                    'ruc' => 'required',
                    'area' => 'required',
                    'localidad' => 'required',
                );
                $mensajes = array(
                    'razonsocial.required'         => 'Debe ingresar la Razón Social',
                    'girocomercial.required'         => 'Debe ingresar el nombre del Giro Comercial',
                    'direccion.required'         => 'Debe ingresar una dirección',
                    'observacion.required'         => 'Debe ingresar una observación',
                    'conclusiones.required'         => 'Debe ingresar las conclusiones',
                    'descripcion.required'         => 'Debe ingresar una descripción',
                    'representante.required'         => 'Debe ingresar el representante',
                    'dni.required'         => 'Debe ingresar el DNI',
                    'ruc.required'         => 'Debe ingresar el RUC',
                    'area.required'         => 'Debe ingresar el área',
                    'localidad.required'         => 'Debe ingresar la localidad',
                );
                break;
            case 'EDIFICACIONES URBANAS (LICENCIA DE EDIFICACIÓN O CONSTRUCCIONES)':
                break;
            case 'SALUBRIDAD':
                $reglas     = array(
                    'razonsocial' => 'required',
                    'girocomercial' => 'required',
                    'direccion' => 'required',
                    'observacion' => 'required',
                    'conclusiones' => 'required',
                    'descripcion' => 'required',
                    'representante' => 'required',
                    'dni' => 'required',
                    'ruc' => 'required',
                );
                $mensajes = array(
                    'razonsocial.required'         => 'Debe ingresar la Razón Social',
                    'girocomercial.required'         => 'Debe ingresar el nombre del Giro Comercial',
                    'direccion.required'         => 'Debe ingresar una dirección',
                    'observacion.required'         => 'Debe ingresar una observación',
                    'conclusiones.required'         => 'Debe ingresar las conclusiones',
                    'descripcion.required'         => 'Debe ingresar una descripción',
                    'representante.required'         => 'Debe ingresar el representante',
                    'dni.required'         => 'Debe ingresar el DNI',
                    'ruc.required'         => 'Debe ingresar el RUC',
                );
                
                break;
            case 'DEFENSA CIVIL':
                break;
        }

        $validacion = Validator::make($request->all(), $reglas, $mensajes);
                if ($validacion->fails()) {
                    return $validacion->messages()->toJson();
                }
                $error = DB::transaction(function() use($request){
                    $inspeccion = new Inspeccion();
                    $inspeccion->numero          = Libreria::getParam($request->input('numero'));
                    $inspeccion->tipo_id            = strtoupper(Libreria::getParam($request->input('tipo')));
                    $inspeccion->ordenpago_id    = Libreria::getParam($request->input('ordenpago_id'), null);
                    $inspeccion->fecha                 = date("Y-m-d H:i:s");
                    $inspeccion->observacion     = strtoupper($request->input('observacion'));
                    $inspeccion->conclusiones     = strtoupper($request->input('conclusiones'));
                    $inspeccion->descripcion     = strtoupper($request->input('descripcion'));
                    $inspeccion->representante     = strtoupper($request->input('representante'));
                    $inspeccion->direccion     = strtoupper($request->input('direccion'));
                    $inspeccion->razonsocial     = strtoupper($request->input('razonsocial'));
                    $inspeccion->girocomercial     = strtoupper($request->input('girocomercial'));
                    $inspeccion->dni     = strtoupper($request->input('dni'));
                    $inspeccion->ruc     = strtoupper($request->input('ruc'));
                    $inspeccion->localidad          = Libreria::getParam($request->input('localidad'));
                    $inspeccion->area          = Libreria::getParam($request->input('area'));

                    if($request->hasFile('file')){
                        $file = $request->file('file');
                        $extension = $request->file('file')->getClientOriginalExtension();
                        $nombre =  time().'.'.$extension;
                        \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                        // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                        $inspeccion->archivo = $nombre;
                    }
                    $inspeccion->save();
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
        $existe = Libreria::verificarExistencia($id, 'inspeccion');
        if ($existe !== true) {
            return $existe;
        }
        $tipostramite = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $cboOrdenpago = ['' => 'Seleccione una opcion'] + Ordenpago::pluck('numero', 'id')->all();
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $inspeccion = Inspeccion::find($id);
        $toggletipo = $inspeccion->tipo_id;
        $entidad  = 'inspeccion';
        $formData = array('inspeccion.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('inspeccion', 'formData', 'entidad', 'boton', 'listar', 'tipostramite', 'cboOrdenpago', 'toggletipo'));
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
        $existe = Libreria::verificarExistencia($id, 'inspeccion');

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
            $inspeccion = Inspeccion::find($id);
            $inspeccion->descripcion = strtoupper($request->input('descripcion'));
            $inspeccion->save();
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
        $existe = Libreria::verificarExistencia($id, 'inspeccion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $inspeccion = Inspeccion::find($id);
            $inspeccion->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'inspeccion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Inspeccion::find($id);
        $entidad  = 'inspeccion';
        $formData = array('route' => array('inspeccion.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function pdfInspeccion($id){
        $inspeccion = Inspeccion::find($id);
        $tipo = $inspeccion->tipo_id;
        $data = $inspeccion;
        switch ($tipo) {
            case '1':
                $pdf = PDF::loadView('gestion.pdf.inspeccion.licenciayautorizacion.licencia', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '2':
                break;
            case '3':
                $pdf = PDF::loadView('gestion.pdf.inspeccion.salubridad.salubridad', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '4':
                break;
        }
        $nombre = 'inspeccion:' . $inspeccion->numero . '-' . $inspeccion->fecha . '.pdf';
        return $pdf->stream($nombre);
    }
    
    
    public  function descargar($nombre){

        $storage_path = storage_path();
        // $url = $storage_path.'/public/archivos2/'.$nombre;// depende de root en el archivo filesystems.php.
        //verificamos si el archivo existe y lo retornamos
        // if (\Storage::exists($nombre))
        // {
        // }
         $url = '/public/archivos2/'.$nombre;
        return Storage::disk('local')->response($url);
        //si no se encuentra lanzamos un error 404.
        // abort(404);
    }

    public function generarNumero(Request $request)
    {
        $tipo          = $request->input('tipo');
        $numerotramite = Inspeccion::NumeroSigue($tipo);
        echo $numerotramite;
    }
}
