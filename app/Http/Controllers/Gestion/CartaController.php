<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Gestion\Tipotramitenodoc;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Librerias\Libreria;
use App\Models\Gestion\Carta;
use App\Models\Gestion\Inspeccion;

class CartaController extends Controller
{
    protected $folderview      = 'gestion.carta';
    protected $tituloAdmin     = 'carta';
    protected $tituloRegistrar = 'Registrar Carta';
    protected $tituloModificar = 'Modificar Carta';
    protected $tituloEliminar  = 'Eliminar Carta';
    protected $rutas           = array(
            'create' => 'carta.create', 
            'edit'   => 'carta.edit', 
            'delete' => 'carta.eliminar',
            'search' => 'carta.buscar',
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
        $entidad          = 'carta';
        $numero           = Libreria::getParam($request->input('numero'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $contribuyente    = Libreria::getParam($request->input('contribuyente'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $resultado        = Carta::with('inspeccion')->listar($numero, $fecinicio, $fecfin, $contribuyente, $tipo);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha Notificación', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha Límite', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Plazo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Número', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Destinatario', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Asunto', 'numero' => '1');
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
        $entidad          = 'carta';
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
        if($request->id_inspeccion){
            $inspeccion = Inspeccion::find($request->id_inspeccion);
            $toggletipo = $inspeccion->tipo_id;
            if($request->entidad){
                $entidad2='carta';
            }else{
                $entidad2='inspeccion';
            }
        }else{
            $toggletipo = null;
            $inspeccion=null;
            $entidad2=null;
        }
        $entidad  = 'carta';
        $carta = null;     
        $cboInspecciones =['' => 'Seleccione una opcion'] + Inspeccion::get()->pluck('full_inspeccion', 'id')->all();
        $tipostramite = ['' => 'Seleccione'] + Tipotramitenodoc::pluck('descripcion', 'id')->all();
        $formData = array('carta.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('carta', 'formData', 'entidad', 'boton', 'listar' ,'tipostramite', 'toggletipo', 'inspeccion', 'cboInspecciones', 'entidad2'));
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
            'tipo_id' => 'required',
            'asunto' => 'required',
            'destinatario' => 'required',
            'razonsocial' => 'required',
            'direccion' => 'required',
            'cuerpo' => 'required',

        );
        $mensajes = array(
            'tipo_id.required'         => 'Debe ingresar el Tipo de Documento',
            'asunto.required'         => 'Debe ingresar el asunto',
            'destinatario.required'         => 'Debe ingresar el destinatario',
            'razonsocial.required'         => 'Debe ingresar la razon social',
            'cuerpo.required'         => 'Debe ingresar el cuerpo del documento',
            'direccion.required'         => 'Debe ingresar una direccion',
        );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        if($request->aviso=='Notificacion'){
            $reglas     = array(
                'fechalimite' => 'required',
                'plazo' => 'required|numeric',
            );
            $mensajes = array(
               'fechalimite.required'         => 'Debe ingresar el nombre la Fecha Límite',
                'plazo.required'         => 'Debe ingresar el plazo',
            );
            $validacion = Validator::make($request->all(), $reglas, $mensajes);
            if ($validacion->fails()) {
                return $validacion->messages()->toJson();
            }
        }

        $error = DB::transaction(function() use($request){
            $carta = new Carta();
            $carta->fechainicial                 = date("Y-m-d H:i:s");
            $carta->fechalimite          = Libreria::getParam($request->input('fechalimite'));
            $carta->tipo_id            = strtoupper(Libreria::getParam($request->input('tipo_id')));
            if($request->input('inspeccion_idSelect')){
                $carta->inspeccion_id            = strtoupper(Libreria::getParam($request->input('inspeccion_idSelect')));
            }else{
                $carta->inspeccion_id            = strtoupper(Libreria::getParam($request->input('inspeccion_id')));
            }
            $carta->plazo         = Libreria::getParam($request->input('plazo'));
            $carta->asunto   = strtoupper(Libreria::getParam($request->input('asunto')));
            $carta->numero   = strtoupper(Libreria::getParam($request->input('numero')));
            $carta->direccion       = strtoupper(Libreria::getParam($request->input('direccion')));
            $carta->cuerpo       = Libreria::getParam($request->input('cuerpo'));
            $carta->razonsocial       = strtoupper(Libreria::getParam($request->input('direccion')));
            $carta->destinatario       = strtoupper(Libreria::getParam($request->input('destinatario')));
            $carta->aviso       = strtoupper(Libreria::getParam($request->input('aviso')));
            $carta->save();

            if(!is_null($request->inspeccion_id)){
                $inspeccion = Inspeccion::find($request->inspeccion_id);
                if($request->aviso=='Notificacion'){
                    $inspeccion->update([
                        'estado'=>'NOTIFICADO',
                    ]);
                }else{
                    $inspeccion->update([
                        'estado'=>'RECHAZADO',
                    ]);
                }
            }
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
        $existe = Libreria::verificarExistencia($id, 'carta');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $carta = carta::find($id);
        $entidad  = 'carta';
        $formData = array('carta.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('carta', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'carta');

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
            $carta = carta::find($id);
            $carta->descripcion = strtoupper($request->input('descripcion'));
            $carta->save();
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
        $existe = Libreria::verificarExistencia($id, 'carta');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $carta = carta::find($id);
            $carta->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'carta');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = carta::find($id);
        $entidad  = 'carta';
        $formData = array('route' => array('carta.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
    
    public function pdf($id){
        $existe = Libreria::verificarExistencia($id, 'carta');
        if ($existe !== true) {
            return $existe;
        }

        $data = Carta::find($id);
        $tipo = $data->tipo_id;
        $cuerpo = $data->cuerpo;
        $cuerpo = str_replace(array("\r\n", "\n\r", "\r", "\n"), "????", $cuerpo);
        $cuerpo=explode("????", $cuerpo);
        switch ($tipo) {
            case '1':
                $pdf = PDF::loadView('gestion.pdf.carta.licencias', compact('data', 'cuerpo'))->setPaper('a4', 'portrait');
                break;
            case '2':
                $pdf = PDF::loadView('gestion.pdf.carta.edificaciones', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '3':
                $pdf = PDF::loadView('gestion.pdf.carta.salubridad', compact('data'))->setPaper('a4', 'portrait');
                break;
            case '4':
                $pdf = PDF::loadView('gestion.pdf.carta.defensa', compact('data'))->setPaper('a4', 'portrait');
                break;
        }
        $nombre = 'carta:' . $data->numero . '-' . $data->fecha . '.pdf';
        return $pdf->stream($nombre);
    } 

    public function generarNumero(Request $request)
    {
        $tipo          = $request->input('tipo');

        $numerotramite = Carta::NumeroSigue($tipo);
        echo $numerotramite;
    }
}
