<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Librerias\Libreria;
use App\Models\Gestion\ResolucionSancion;

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
        $cabecera[]       = array('valor' => 'Sub Gerencia', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Ordenanza', 'numero' => '1');
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
        return view($this->folderview.'.mant')->with(compact('resolucionsancion', 'formData', 'entidad', 'boton', 'listar'));
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
            'fechafin' => 'required',
            'ordenanza' => 'required',
            'subgerencia' => 'required',
            'fiscalizador' => 'required',
           // 'dnifiscalizador' => 'required',
            'representante' => 'required',
            'dnirepresentante' => 'required',
           // 'ocurrencia' => 'required',
           // 'observaciones' => 'required',
            'conclusiones' => 'required',
            'direccion' => 'required',

        );
        $mensajes = array(
            'fecha.required'         => 'Debe ingresar la fecha de inicio de la Fiscalizacion',
            'fechafin.required'         => 'Debe ingresar la fecha de fin de la Fiscalizacion',
            'numero.required'         => 'Debe ingresar el numero',
            'ordenanza.required'         => 'Debe ingresar la Ordenanza',
            'subgerencia.required'         => 'Debe ingresar la subgerencia',
            'fiscalizador.required'         => 'Debe ingresar el nombre del fiscalizador',
           // 'dnifiscalizador.required'         => 'Debe ingresar el DNI del fiscalizador',
            'representante.required'         => 'Debe ingresar el nombre del representante',
            'dnirepresentante.required'         => 'Debe ingresar el DNI del representante',
            'direccion.required'         => 'Debe ingresar una direccion',
            'conclusiones.required'         => 'Debe ingresar las conclusiones',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $conclusiones = implode(';', $request->conclusiones);
        $error = DB::transaction(function() use($request, $conclusiones){
            $resolucionsancion = new resolucionsancion();
            $resolucionsancion->fecha                 = $request->fecha;
            $resolucionsancion->fechafin                 = $request->fechafin;
            $resolucionsancion->ordenanza            = strtoupper(Libreria::getParam($request->input('ordenanza')));
            $resolucionsancion->numero            = strtoupper(Libreria::getParam($request->input('numero')));
            $resolucionsancion->subgerencia            = strtoupper(Libreria::getParam($request->input('subgerencia')));
            $resolucionsancion->fiscalizador            = strtoupper(Libreria::getParam($request->input('fiscalizador')));
            $resolucionsancion->dnifiscalizador            = strtoupper(Libreria::getParam($request->input('dnifiscalizador')));
            $resolucionsancion->participante            = strtoupper(Libreria::getParam($request->input('participante')));
            $resolucionsancion->condicionparticipante            = strtoupper(Libreria::getParam($request->input('condicionparticipante')));
            $resolucionsancion->ruc            = strtoupper(Libreria::getParam($request->input('ruc')));
            $resolucionsancion->direccion            = strtoupper(Libreria::getParam($request->input('direccion')));
            $resolucionsancion->razonsocial            = strtoupper(Libreria::getParam($request->input('razonsocial')));
            $resolucionsancion->girocomercial            = strtoupper(Libreria::getParam($request->input('girocomercial')));
            $resolucionsancion->representante            = strtoupper(Libreria::getParam($request->input('representante')));
            $resolucionsancion->dnirepresentante            = strtoupper(Libreria::getParam($request->input('dnirepresentante')));
            $resolucionsancion->calidadrepresentante            = strtoupper(Libreria::getParam($request->input('calidadrepresentante')));
            $resolucionsancion->ocurrencia            = strtoupper(Libreria::getParam($request->input('ocurrencia')));
            $resolucionsancion->observaciones            = strtoupper(Libreria::getParam($request->input('observaciones')));
            $resolucionsancion->conclusiones            = $conclusiones;
            if($request->hasFile('file')){
                $file = $request->file('file');
                $extension = $request->file('file')->getClientOriginalExtension();
                $nombre =  time().'.'.$extension;
                \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                $resolucionsancion->imagen = $nombre;
            }
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
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('resolucionsancion', 'formData', 'entidad', 'boton', 'listar'));
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
        $reglas     = array('descripcion' => 'required');
        $mensajes = array(
            'descripcion.required'         => 'Debe ingresar una descripcion'
            );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $resolucionsancion = resolucionsancion::find($id);
            $resolucionsancion->descripcion = strtoupper($request->input('descripcion'));
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
        $pdf = PDF::loadView('gestion.pdf.resolucionsancion.pdf', compact('data'))->setPaper('a4', 'portrait');
        $nombre = 'resolucionsancion:' . $data->numero . '-' . $data->fecha . '.pdf';
        return $pdf->stream($nombre);
    } 

    public function generarNumero(Request $request)
    {
        $numerotramite = ResolucionSancion::NumeroSigue();
        echo $numerotramite;
    }
}
