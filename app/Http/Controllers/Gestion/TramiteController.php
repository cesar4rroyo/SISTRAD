<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Gestion\Tramite;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Models\Control\Archivador;
use App\Models\Control\Area;
use App\Models\Control\Empresacourier;
use App\Models\Control\Motivorechazo;
use App\Models\Control\Procedimiento;
use App\Models\Control\Tipodocumento;
use App\Models\Gestion\Seguimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TramiteController extends Controller
{
    protected $folderview      = 'gestion.tramite';
    protected $tituloAdmin     = 'Tramite';
    protected $tituloRegistrar = 'Registrar Tramite';
    protected $tituloModificar = 'Modificar Tramite';
    protected $tituloEliminar  = 'Eliminar Tramite';
    protected $rutas           = array('create' => 'tramite.create', 
            'edit'   => 'tramite.edit', 
            'delete' => 'tramite.eliminar',
            'search' => 'tramite.buscar',
            'index'  => 'anio.index',
            'accion'=>'tramite.accion',
            'confirmacion'=>'tramite.confirmacion',
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
        // dd($request->all());
        $usuario = session()->get('personal');
        $personal_id = $usuario['id'];
        $area_actual = (session()->get('area')['area']['descripcion']) ?? 'MESA DE PARTES';
        $area_id = $usuario['area_id'];
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'tramite';
        $modo             = Libreria::getParam($request->input('modo'));
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $nombre           = Libreria::getParam($request->input('numero'));
        $resultado        = Tramite::with('seguimientos', 'procedimiento')->listar($nombre , $fecinicio, $fecfin, $modo, $area_id, $personal_id);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Prioridad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Numero', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Documento', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Asunto', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Origen', 'numero' => '1');
        // $cabecera[]       = array('valor' => 'Localización', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Remitente', 'numero' => '1');
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'modo'));
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
        $user = Auth::user();
        // dd($user->toArray);
        $entidad          = 'tramite';
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
        $entidad  = 'tramite';
        $tramite = null;
       
        $tipodocumentos = [""=>'Seleccione'] + Tipodocumento::pluck('descripcion', 'id')->all();
        $procedimientos = [""=>'Seleccione'] + Procedimiento::pluck('id','descripcion')->all();
        $formData = array('tramite.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('tramite', 'formData', 'entidad', 'boton', 'listar', 'tipodocumentos', 'procedimientos'));
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
            'asunto' => 'required',
            'folios' => 'required|integer',
            'tipodocumento' => 'required|exists:tipodocumento,id',
            'procedimiento' => 'required_if:tipotramite,tupa'
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar el número',
            'asunto.required'         => 'Debe ingresar el asunto',
            'folios.required'         => 'Debe ingresar el asunto',
            'tipodocumento.required'         => 'Debe seleccionar el tipo de documento'
            );
            
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $user = Auth::user();
        $error = DB::transaction(function() use($request , $user){
            $tramite = new Tramite();
            $tramite->tipo                  = strtoupper($request->input('tipotramite'));
            $tramite->fecha                 = date("Y-m-d H:i:s");
            $tramite->numero                = Libreria::getParam($request->input('numero'));
            $tramite->asunto                = Libreria::getParam($request->input('asunto'));
            $tramite->remitente             = Libreria::getParam($request->input('remitente'));
            $tramite->formarecepcion        = strtoupper(Libreria::getParam($request->input('formarecepcion')));
            $tramite->folios                = Libreria::getParam($request->input('folios'));
            $tramite->observacion           = Libreria::getParam($request->input('observacion'));
            $tramite->prioridad             = strtoupper(Libreria::getParam($request->input('prioridad')));
            $tramite->situacion             = "REGISTRADO"; //REGISTRADO , EN PROCESO, FINALIZADO , RECHAZADO, DERIVADO
            $tramite->tipodocumento_id      = Libreria::getParam($request->input('tipodocumento'));
            if($tramite->tipo == 'TUPA'){
                $tramite->procedimiento_id  = Libreria::getParam($request->input('procedimiento'));
            }
            $tramite->personal_id           = $user->personal_id;
            $tramite->personal_id           = $user->personal_id;
            $tramite->archivador_id         = Libreria::getParam($request->input('archivador'));
            // $tramite->motivorechazo_id     = "";
            if($tramite->tipo == 'COURIER'){
                $tramite->empresacourier_id = Libreria::getParam($request->input('destino')); 
            }
            $tramite->tramiteref_id         = Libreria::getParam($request->tramiteref);
            $tramite->save();


            $seguimiento = new Seguimiento();
            $seguimiento->fecha = date("Y-m-d H:i:s");
            $seguimiento->accion = 'REGISTRAR';  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR, FINALIZAR
            $seguimiento->correlativo = '1';
            $seguimiento->correlativo_anterior = '1';
            // $seguimiento->observacion;
            // $seguimiento->ultimo;
            $seguimiento->area = $user->personal?$user->personal->area->descripcion : 'MESA DE PARTES';
            $seguimiento->cargo = '';
            $seguimiento->persona = '';
            // $seguimiento->recibido ;
            // $seguimiento->fecharecibe;
            // $seguimiento->tiposeguimiento ;
            // $seguimiento->ruta;
            $seguimiento->tramite_id = $tramite->id;
            $seguimiento->personal_id = $user->personal_id;
            $seguimiento->area_id  = $user->personal?$user->personal->area_id : null;
            // $seguimiento->motivocourier_id; 
            // $seguimiento->motivorechazo_id;
            $seguimiento->save(); 
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

    
    public function confirmacion($id, $listarLuego, $accion)
    {
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Tramite::with('seguimientos.personal', 'procedimiento', 'seguimientos.areas')->find($id);
        $entidad  = 'tramite';
        $formData = array('route' => array('tramite.accion', $id, $accion), 'method' => 'POST', 'enctype'=>'multipart/form-data','class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Aceptar';
        $cboMotivos = ['' => 'Seleccione uno'] + Motivorechazo::pluck('descripcion', 'id')->all();
        $cboAreas = ['' => 'Seleccione una área'] + Area::pluck('descripcion', 'id')->all();
        $cboArchivadores = ['' => 'Seleccione una opción'] + Archivador::pluck('descripcion', 'id')->all();
        $cboOpcion = [''=>'Seleccione uno', 'anterior'=>'Sí, enviar al área anterior', 'fin'=>'No, finalizar y empezar de nuevo'];
        return view('reusable.confirmarTramite')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar', 'accion', 'cboMotivos', 'cboAreas', 'cboOpcion', 'cboArchivadores'));
    }

    /**
     * Aceptacion del tramite.    
     */
    public function accion(Request $request, $id, $accion)
    {
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id, $accion, $request){
            $usuario = session()->get('personal');
            $tramite = Tramite::find($id);
            switch ($accion) {
                case 'aceptar':                    
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'ACEPTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => '',                
                        'tramite_id' => $id,
                        'fecharecibe'=> date("Y-m-d H:i:s"),
                        'recibido'=>'SI',
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                    ]);
                    $tramite->update([
                        'situacion'=>'EN PROCESO',
                    ]);
                    break;
                case 'rechazar':
                    $reglas     = array('motivorechazo_id' => 'required');
                    $mensajes = array(
                        'motivorechazo_id.required' => 'Debe ingresar un motivo de rechazo'
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }
                    
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'RECHAZAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'motivorechazo_id'=>$request->motivorechazo_id,
                        'observacion'=> Libreria::getParam($request->input('observacion')),
                    ]);
                    $tramite->update([
                        'situacion'=>'RECHAZADO',
                    ]);
                    break;
                case 'finalizar':                    
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'FINALIZAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'motivorechazo_id'=>$request->motivorechazo_id,
                        'observacion'=> Libreria::getParam($request->input('observacion')),
                        'ultimo'=>'S',
                    ]);
                    $tramite->update([
                        'situacion'=>'FINALIZADO',
                    ]);
                    break;
                case 'derivar':
                    $reglas     = array('area_id' => 'required');
                    $mensajes = array(
                        'area_id.required' => 'Debe ingresar el área de destino'
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }
                    $area = Area::find($request->area_id)->toArray();
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'DERIVAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>   $usuario['area'] ? $usuario['area']['descripcion'] : null, //el última área que hizo la accion de derivar
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $area['id'], //id_area a dónde se derivo el trámite
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion'=> Libreria::getParam($request->input('observacion')),
                    ]);
                    $tramite->update([
                        'situacion'=>'DERIVADO',
                    ]);
                    break;
                case 'adjuntar':
                    $reglas     = array('archivo' => 'required', 'observacion'=>'required');
                    $mensajes = array(
                        'archivo.required' => 'Debe ingresar un archivo',
                        'observacion.required' => 'Debe ingresar un observacion sobre el archivo',
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }
                    $archivo = $request->file('archivo')->store('public/archivos');
                    $ruta = Storage::url($archivo);
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento=Seguimiento::create([
                        'fecha'=> date("Y-m-d H:i:s"),
                        'accion' => 'ADJUNTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior+1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],                
                        'tramite_id' => $id,
                        'ruta'=>$ruta,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id'=>$usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion'=> Libreria::getParam($request->input('observacion')),
                    ]);
                    break;
                case 'seguimiento':
                    break;
                case 'archivar':
                    $reglas     = array('archivador_id' => 'required');
                    $mensajes = array(
                        'archivador_id.required' => 'Debe ingresar el archivador',
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }
                    $tramite->update([
                        'archivador_id'=>$request->archivador_id,
                    ]);
                    break;

            }
            
        });
        return is_null($error) ? "OK" : $error;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $tramite = Tramite::find($id);
        $entidad  = 'tramite';
        $formData = array('tramite.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('tramite', 'formData', 'entidad', 'boton', 'listar'));
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
        $existe = Libreria::verificarExistencia($id, 'tramite');

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
            $tramite = Tramite::find($id);
            $tramite->descripcion = strtoupper($request->input('descripcion'));
            $tramite->save();
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
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $tramite = Tramite::find($id);
            $tramite->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'tramite');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Tramite::find($id);
        $entidad  = 'tramite';
        $formData = array('route' => array('tramite.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function listarProcedimientos(Request $request){
        $q = $request->input('term');
        $resultados = Procedimiento::where('descripcion' , 'LIKE' , '%'.$q.'%')->get();
        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = [ "text" => $r->descripcion ,"id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarEmpresascourier(Request $request){
        $q = $request->input('term');

        $resultados = Empresacourier::where(function($query) use($q){
            $query->where('razonsocial','LIKE', '%'.$q.'%')
                 ->orWhere('ruc','LIKE' , '%'.$q.'%');   
        })->get();

        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = [ "text" => $r->ruc.'-'.$r->razonsocial ,"id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarAreas(Request $request){
        $q = $request->input('term');

        $resultados = Area::where('descripcion','LIKE', '%'.$q.'%')->get();

        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = [ "text" => $r->descripcion,"id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarArchivadores(Request $request){
        $q = $request->input('term');

        $resultados = Archivador::where(function($query) use($q){
            $query->where('descripcion','LIKE', '%'.$q.'%')
                 ->orWhere('codigo','LIKE' , '%'.$q.'%');   
        })->get();
        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = [ "text" => $r->codigo.'-'.$r->descripcion ,"id" => $r->id];
        }
        return  \json_encode($data);
    }
    
    public function listarTramites(Request $request){
        $q = $request->input('term');

        $resultados = Tramite::where('numero','LIKE', '%'.$q.'%')->get();
        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = [ "text" => $r->numero ,"id" => $r->id];
        }
        return  \json_encode($data);
    }
    
    
}
