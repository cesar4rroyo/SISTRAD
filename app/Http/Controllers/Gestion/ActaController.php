<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Librerias\Libreria;
use App\Models\Gestion\Acta;

class ActaController extends Controller
{
    protected $folderview      = 'gestion.acta';
    protected $tituloAdmin     = 'acta';
    protected $tituloRegistrar = 'Registrar Acta de Fiscalización';
    protected $tituloModificar = 'Modificar Acta de Fiscalización';
    protected $tituloEliminar  = 'Eliminar Acta de Fiscalización';
    protected $rutas           = array(
            'create' => 'acta.create', 
            'edit'   => 'acta.edit', 
            'delete' => 'acta.eliminar',
            'search' => 'acta.buscar',
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
        $entidad          = 'acta';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
       // $contribuyente    = Libreria::getParam($request->input('contribuyente'));
       // $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = Acta::listar($numero, $fecinicio, $fecfin);
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
        $entidad          = 'acta';
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
        $entidad  = 'acta';
        $acta = null;     
        $formData = array('acta.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('acta', 'formData', 'entidad', 'boton', 'listar'));
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
            $acta = new Acta();
            $acta->fecha                 = $request->fecha;
            $acta->fechafin                 = $request->fechafin;
            $acta->ordenanza            = strtoupper(Libreria::getParam($request->input('ordenanza')));
            $acta->numero            = strtoupper(Libreria::getParam($request->input('numero')));
            $acta->subgerencia            = strtoupper(Libreria::getParam($request->input('subgerencia')));
            $acta->fiscalizador            = strtoupper(Libreria::getParam($request->input('fiscalizador')));
            $acta->dnifiscalizador            = strtoupper(Libreria::getParam($request->input('dnifiscalizador')));
            $acta->participante            = strtoupper(Libreria::getParam($request->input('participante')));
            $acta->condicionparticipante            = strtoupper(Libreria::getParam($request->input('condicionparticipante')));
            $acta->ruc            = strtoupper(Libreria::getParam($request->input('ruc')));
            $acta->direccion            = strtoupper(Libreria::getParam($request->input('direccion')));
            $acta->razonsocial            = strtoupper(Libreria::getParam($request->input('razonsocial')));
            $acta->girocomercial            = strtoupper(Libreria::getParam($request->input('girocomercial')));
            $acta->representante            = strtoupper(Libreria::getParam($request->input('representante')));
            $acta->dnirepresentante            = strtoupper(Libreria::getParam($request->input('dnirepresentante')));
            $acta->calidadrepresentante            = strtoupper(Libreria::getParam($request->input('calidadrepresentante')));
            $acta->ocurrencia            = strtoupper(Libreria::getParam($request->input('ocurrencia')));
            $acta->observaciones            = strtoupper(Libreria::getParam($request->input('observaciones')));
            $acta->conclusiones            = $conclusiones;
            if($request->hasFile('file')){
                $file = $request->file('file');
                $extension = $request->file('file')->getClientOriginalExtension();
                $nombre =  time().'.'.$extension;
                \Storage::disk('local')->put('public/archivos2/'.$nombre,  \File::get($file));
                // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                $acta->imagen = $nombre;
            }
            $acta->save();

        });
        $ultimo = acta::orderBy('id', 'DESC')->first()->toArray()['id'];

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
        $existe = Libreria::verificarExistencia($id, 'actafiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $acta = acta::find($id);
        $entidad  = 'acta';
        $formData = array('acta.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('acta', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'actafiscalizacion');

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
            $acta = acta::find($id);
            $acta->descripcion = strtoupper($request->input('descripcion'));
            $acta->save();
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
        $existe = Libreria::verificarExistencia($id, 'actafiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $acta = Acta::find($id);
            $acta->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'actafiscalizacion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Acta::find($id);
        $entidad  = 'acta';
        $formData = array('route' => array('acta.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'actafiscalizacion');
        if ($existe !== true) {
            return $existe;
        }

        $data = Acta::find($id);
        $pdf = PDF::loadView('gestion.pdf.acta.acta', compact('data'))->setPaper('a4', 'portrait');
        $nombre = 'Acta:' . $data->numero . '-' . $data->fecha . '.pdf';
        return $pdf->stream($nombre);
    } 

    public function generarNumero(Request $request)
    {
        $numerotramite = Acta::NumeroSigue();
        echo $numerotramite;
    }
}
