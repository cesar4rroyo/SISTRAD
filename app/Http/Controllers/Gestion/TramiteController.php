<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Gestion\Tramite;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use App\Models\Admin\Personal;
use App\Models\Contribuyente\Pretramite;
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
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;

class TramiteController extends Controller
{
    protected $folderview      = 'gestion.tramite';
    protected $tituloAdmin     = 'Tramite';
    protected $tituloRegistrar = 'Registrar Tramite';
    protected $tituloModificar = 'Modificar Tramite';
    protected $tituloEliminar  = 'Eliminar Tramite';
    protected $rutas           = array(
        'create' => 'tramite.create',
        'edit'   => 'tramite.edit',
        'delete' => 'tramite.eliminar',
        'search' => 'tramite.buscar',
        'index'  => 'anio.index',
        'accion' => 'tramite.accion',
        'confirmacion' => 'tramite.confirmacion',
        'printseguimiento' => 'tramite.printseguimiento'
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
        $usuario = session()->get('personal');
        $personal_id = $usuario['id'];
        $tipo = $request->input('tipos');
        $area_actual = (session()->get('area')['area']['descripcion']) ?? 'MESA DE PARTES';
        $area_id = $usuario['area_id'];
        $pagina           = $request->input('page');
        $filas            = ($request->filas) ? $request->filas : 10;
        $entidad          = 'tramite';
        $modo             = Libreria::getParam($request->input('modo'), 'general');
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $numero           = Libreria::getParam($request->input('numero'));
        $remitente        = Libreria::getParam($request->input('remisor'));
        $resultado        = Tramite::with('seguimientos', 'procedimiento.rutas.areainicio', 'procedimiento.rutas.areafin', 'latestSeguimiento')->listar2($numero, $fecinicio, $fecfin, $modo, $area_id, $personal_id, $tipo, $remitente);
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
        $cabecera[]       = array('valor' => 'Comentario', 'numero' => '1');
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
            $cboTipoTramite  = ["" => 'Todos', 'TUPA' => 'Tupa', 'INTERNO' => 'Interno'];
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta', 'modo', 'area_id', 'area_actual', 'cboTipoTramite'));
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
        $user = Auth::user();
        // dd($user->toArray);
        $entidad          = 'tramite';
        $cboTipoTramite  = ["" => 'Todos', 'TUPA' => 'Tupa', 'INTERNO' => 'Interno'];
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $mesapartes =  session()->all()['personal']['area']['mesadepartes'];
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboTipoTramite', 'mesapartes'));
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
        $mesapartes =  session()->all()['personal']['area']['mesadepartes'];


        $tipodocumentos = ["" => 'Seleccione'] + Tipodocumento::pluck('descripcion', 'id')->all();
        $procedimientos = ["" => 'Seleccione'] + Procedimiento::pluck('id', 'descripcion')->all();
        $formData = array('tramite.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        $tipo = 'MANUAL';

        return view($this->folderview . '.mant')->with(compact('tipo', 'tramite', 'formData', 'entidad', 'boton', 'listar', 'tipodocumentos', 'procedimientos', 'mesapartes'));
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
            'correo' => 'nullable|email',
            'numero' => 'required',
            'asunto' => 'required',
            'folios' => 'required|integer',
            'tipodocumento' => 'required|exists:tipodocumento,id',
            'procedimiento' => 'required_if:tipotramite,tupa',
            'areadestino' => 'required_if:tipotramite,interno',
            'remitente' => 'required',
        );
        $mensajes = array(
            'numero.required'         => 'Debe ingresar el número',
            'asunto.required'         => 'Debe ingresar el asunto',
            'folios.required'         => 'Debe ingresar la cantidad de folios',
            'tipodocumento.required'         => 'Debe seleccionar el tipo de documento'
        );
        // dd($request->all());
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }

        $user = Auth::user();
        $error = DB::transaction(function () use ($request, $user) {
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
            if ($tramite->tipo == 'TUPA') {
                $tramite->procedimiento_id  = Libreria::getParam($request->input('procedimiento'));
            }
            $tramite->personal_id           = $user->personal_id;
            $tramite->personal_id           = $user->personal_id;
            $tramite->archivador_id         = Libreria::getParam($request->input('archivador'));
            // $tramite->motivorechazo_id     = "";
            if ($tramite->tipo == 'COURIER') {
                $tramite->empresacourier_id = Libreria::getParam($request->input('destino'));
            }
            $tramite->tramiteref_id         = Libreria::getParam($request->tramiteref);
            $tramite->correo                = Libreria::getParam($request->correo);
            if ($request->input('pretramite_id') != '') {
                $tramite->pretramite_id = $request->input('pretramite_id');
            }
            $tramite->save();

            if ($request->input('pretramite_id') != '') {
                $pretramite = Pretramite::find($request->input('pretramite_id'));
                $pretramite->estado = 'CREADO';
                $pretramite->tramite_id = $tramite->id;
                $pretramite->fecha_creado = new DateTime('now');
                $pretramite->save();
            }

            $seguimiento = new Seguimiento();
            $seguimiento->fecha = date("Y-m-d H:i:s");
            $seguimiento->accion = 'REGISTRAR';  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR, FINALIZAR, ADJUNTAR
            $seguimiento->correlativo = '1';
            $seguimiento->correlativo_anterior = '1';
            // $seguimiento->observacion;
            // $seguimiento->ultimo;
            $seguimiento->cargo = $user->personal ? ($user->personal->cargo ? $user->personal->cargo->descripcion : null) : null;
            $seguimiento->persona = $user->personal ? ($user->personal->nombres . ' ' . $user->personal->apellidopaterno . ' ' . $user->personal->apellidomaterno) : null;
            // $seguimiento->recibido ;
            // $seguimiento->fecharecibe;
            // $seguimiento->tiposeguimiento ;
            // $seguimiento->ruta;
            $seguimiento->personal_id = $user->personal_id;
            $seguimiento->cargo_id  = $user->personal ? $user->personal->cargo_id : null;
            $seguimiento->tramite_id = $tramite->id;
            if ($tramite->tipo == 'TUPA') {
                $proc   = Procedimiento::find($tramite->procedimiento_id);
                $area   = Area::find($proc->areainicio_id);
                $seguimiento->area      = $area != null ? $area->descripcion : '';
                $seguimiento->area_id   = $proc->areainicio_id;
                $seguimiento->save();

                //adjuntar documentos
                if ($request->formarecepcion == 'digital') {
                    if ($request->hasFile('ficheros')) {
                        $files = $request->file('ficheros');
                        foreach ($files as $file) {
                            $extension = $file->getClientOriginalExtension();
                            $archivo = $file->storeAs('public/archivos', time() .  '.' . $extension);
                            $ruta = Storage::url($archivo);
                            // $extension = $file->getClientOriginalExtension();
                            // $nombre =  time().'.'.$extension;
                            // \Storage::disk('local')->put('public/archivos/'.$nombre,  \File::get($file));
                            // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                            $ultimo_seguimiento = Seguimiento::where('tramite_id', $tramite->id)->orderBy('id', 'desc')->first();
                            $correlativo_anterior = ($ultimo_seguimiento) ? $ultimo_seguimiento->correlativo : 1;
                            $seguimiento = Seguimiento::create([
                                'fecha' => date("Y-m-d H:i:s"),
                                'accion' => 'ADJUNTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                                'correlativo' => $correlativo_anterior + 1,
                                'correlativo_anterior' => $correlativo_anterior,
                                'area' =>   $user->personal ? ($user->personal->area ? $user->personal->area->descripcion : null) : null, //el última área que hizo la accion de derivar
                                'cargo' => $user->personal ? ($user->personal->cargo ? $user->personal->cargo->descripcion : null) : null,
                                'persona' => $user->personal ? ($user->personal->cargo ? $user->personal->cargo->descripcion : null) : null,
                                'tramite_id' => $tramite->id,
                                'personal_id' => $user->personal_id,
                                'area_id'  => $user->personal ? $user->personal->area_id : null,
                                'cargo_id' => $user->personal ? $user->personal->cargo_id : null,
                                'observacion' => 'ADJUNTANTO ARCHIVOS EN FORMATO DIGITAL',
                                'ruta' => $ruta,
                            ]);
                        }
                    }
                }
            } else {
                $seguimiento->area = $user->personal ? ($user->personal->area ? $user->personal->area->descripcion : null) : null;
                $seguimiento->area_id  = $user->personal ? $user->personal->area_id : null;
                $seguimiento->save();

                //ACEPTAR EL TRAMITE
                // $aceptar = $this->accion( $request , $tramite->id , 'aceptar');

                //adjuntar documentos
                if ($request->formarecepcion == 'digital') {
                    if ($request->hasFile('ficheros')) {
                        $files = $request->file('ficheros');
                        foreach ($files as $file) {
                            $extension = $file->getClientOriginalExtension();
                            $archivo = $file->storeAs('public/archivos', time() .  '.' . $extension);
                            $ruta = Storage::url($archivo);
                            // $extension = $file->getClientOriginalExtension();
                            // $nombre =  time().'.'.$extension;
                            // \Storage::disk('local')->put('public/archivos/'.$nombre,  \File::get($file));
                            // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
                            $ultimo_seguimiento = Seguimiento::where('tramite_id', $tramite->id)->orderBy('id', 'desc')->first();
                            $correlativo_anterior = ($ultimo_seguimiento) ? $ultimo_seguimiento->correlativo : 1;
                            $seguimiento = Seguimiento::create([
                                'fecha' => date("Y-m-d H:i:s"),
                                'accion' => 'ADJUNTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                                'correlativo' => $correlativo_anterior + 1,
                                'correlativo_anterior' => $correlativo_anterior,
                                'area' =>   $user->personal ? ($user->personal->area ? $user->personal->area->descripcion : null) : null, //el última área que hizo la accion de derivar
                                'cargo' => $user->personal ? ($user->personal->cargo ? $user->personal->cargo->descripcion : null) : null,
                                'persona' => $user->personal ? ($user->personal->cargo ? $user->personal->cargo->descripcion : null) : null,
                                'tramite_id' => $tramite->id,
                                'personal_id' => $user->personal_id,
                                'area_id'  => $user->personal ? $user->personal->area_id : null,
                                'cargo_id' => $user->personal ? $user->personal->cargo_id : null,
                                'observacion' => 'ADJUNTANTO ARCHIVOS EN FORMATO DIGITAL',
                                'ruta' => $ruta,
                            ]);
                        }
                    }
                }

                //DERIVAR AL AREA SELECCIONADA 
                $area = Area::find($request->areadestino);
                $ultimo_seguimiento = Seguimiento::where('tramite_id', $tramite->id)->orderBy('id', 'desc')->first();
                $correlativo_anterior = $ultimo_seguimiento->correlativo;
                $seguimiento = Seguimiento::create([
                    'fecha' => date("Y-m-d H:i:s"),
                    'accion' => 'DERIVAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                    'correlativo' => $correlativo_anterior + 1,
                    'correlativo_anterior' => $correlativo_anterior,
                    'area' =>   $user->personal ? ($user->personal->area ? $user->personal->area->descripcion : null) : null, //el última área que hizo la accion de derivar
                    'cargo' => $user->personal ? ($user->personal->cargo ? $user->personal->cargo->descripcion : null) : null,
                    'persona' => $user->personal ? ($user->personal->nombres . ' ' . $user->personal->apellidopaterno . ' ' . $user->personal->apellidomaterno) : null,
                    'tramite_id' => $tramite->id,
                    'personal_id' => $user->personal_id,
                    'area_id'  => $area->id, //id_area a dónde se derivo el trámite
                    'cargo_id' => $user->personal ? $user->personal->cargo_id : null,
                    'observacion' => Libreria::getParam($request->input('observacion')),
                ]);
                $tramite->update([
                    'situacion' => 'DERIVADO',
                ]);
            }
            // //adjuntar documentos
            // if($request->formarecepcion == 'digital'){
            //     if($request->hasFile('ficheros')){
            //         $files = $request->file('ficheros');
            //         foreach ($files as $file) {
            //             $extension = $file->getClientOriginalExtension();
            //             $archivo = $file->storeAs('public/archivos', time() .  '.' .$extension);
            //             $ruta = Storage::url($archivo);
            //             // $extension = $file->getClientOriginalExtension();
            //             // $nombre =  time().'.'.$extension;
            //             // \Storage::disk('local')->put('public/archivos/'.$nombre,  \File::get($file));
            //             // $archivo = $request->file('file')->storeAs('public/archivos2', time() .  '.' .$extension);
            //             $ultimo_seguimiento = Seguimiento::where('tramite_id', $tramite->id)->orderBy('id', 'desc')->first();
            //             $correlativo_anterior = $ultimo_seguimiento->correlativo;
            //             $seguimiento=Seguimiento::create([
            //                 'fecha'=> date("Y-m-d H:i:s"),
            //                 'accion' => 'ADJUNTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
            //                 'correlativo' => $correlativo_anterior+1,
            //                 'correlativo_anterior' => $correlativo_anterior,
            //                 'area' =>   $user->personal?($user->personal->area? $user->personal->area->descripcion : null ): null, //el última área que hizo la accion de derivar
            //                 'cargo' => $user->personal?($user->personal->cargo? $user->personal->cargo->descripcion : null ): null,
            //                 'persona' => $user->personal?($user->personal->cargo? $user->personal->cargo->descripcion : null ): null,           
            //                 'tramite_id' => $tramite->id,
            //                 'personal_id' => $user->personal_id,
            //                 'area_id'  => $user->personal?$user->personal->area_id : null,
            //                 'cargo_id'=>$user->personal?$user->personal->cargo_id : null,
            //                 'observacion'=> 'ADJUNTANTO ARCHIVOS EN FORMATO DIGITAL',
            //                 'ruta'=> $ruta,
            //             ]);
            //         }
            //     }
            // }
            // $seguimiento->motivocourier_id; 
            // $seguimiento->motivorechazo_id;
        });

        $ultimotramite = Tramite::with('procedimiento', 'tipodocumento')->orderBy('id', 'DESC')->first()->toArray()['id'];
        return is_null($error) ? 'id=?' . $ultimotramite : $error;
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

    public function printseguimiento($id)
    {
        $tramite = Tramite::with('seguimientos.areas')->find($id);
        $data = $tramite;
        $pdf = PDF::loadView('gestion.pdf.seguimiento', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('seguimiento.pdf');
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
        $formData = array('route' => array('tramite.accion', $id, $accion), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Aceptar';
        $cboMotivos = ['' => 'Seleccione uno'] + Motivorechazo::pluck('descripcion', 'id')->all();
        $cboAreas = ['' => 'Seleccione una área'] + Area::pluck('descripcion', 'id')->all();
        $cboArchivadores = ['' => 'Seleccione una opción'] + Archivador::pluck('descripcion', 'id')->all();
        $cboOpcion = ['' => 'Seleccione uno', 'anterior' => 'Sí, enviar al área anterior', 'fin' => 'No, finalizar y empezar de nuevo'];
        $usuario = session()->get('personal');
        $area_actual = $usuario['area_id'];
        return view('reusable.confirmarTramite')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar', 'accion', 'cboMotivos', 'cboAreas', 'cboOpcion', 'cboArchivadores', 'area_actual'));
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
        $error = DB::transaction(function () use ($id, $accion, $request) {
            $usuario = session()->get('personal');
            $tramite = Tramite::find($id);
            switch ($accion) {
                case 'aceptar':
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento = Seguimiento::create([
                        'fecha' => date("Y-m-d H:i:s"),
                        'accion' => 'ACEPTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior + 1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                        'tramite_id' => $id,
                        'fecharecibe' => date("Y-m-d H:i:s"),
                        'recibido' => 'SI',
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                    ]);
                    $tramite->update([
                        'situacion' => 'EN PROCESO',
                    ]);
                    break;
                case 'rechazar':
                    $reglas     = array('motivorechazo_id' => 'required', 'observacion' => 'required', 'envio' => 'required');
                    $mensajes = array(
                        'motivorechazo_id.required' => 'Debe ingresar un motivo de rechazo',
                        'observacion.required' => 'Debe ingresar una observación',
                        'envio.required' => 'Debe elegir que es lo que quiere hacer con el trámite',
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }


                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    if ($request->envio == 'anterior') {
                        $penultimo_Seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->take(2)->get()[1];
                        $seguimiento = Seguimiento::create([
                            'fecha' => date("Y-m-d H:i:s"),
                            'accion' => 'RECHAZAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                            'correlativo' => $correlativo_anterior + 1,
                            'correlativo_anterior' => $correlativo_anterior,
                            'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                            'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                            'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                            'tramite_id' => $id,
                            'personal_id' => $usuario['id'],
                            'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                            'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                            'motivorechazo_id' => $request->motivorechazo_id,
                            'observacion' => Libreria::getParam($request->input('observacion')),
                        ]);

                        //otro seguimiento para derivar al anterior
                        $area_id = $ultimo_seguimiento->area_id;
                        if ($area_id == $usuario['area']['id']) {
                            $area_id = $penultimo_Seguimiento->area_id;
                        }
                        $seguimiento = Seguimiento::create([
                            'fecha' => date("Y-m-d H:i:s"),
                            'accion' => 'DERIVAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                            'correlativo' => $correlativo_anterior + 2,
                            'correlativo_anterior' => $correlativo_anterior + 1,
                            'area' =>   $usuario['area'] ? $usuario['area']['descripcion'] : null, //el última área que hizo la accion de derivar
                            'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                            'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                            'tramite_id' => $id,
                            'personal_id' => $usuario['id'],
                            'area_id'  => $area_id, //id_area a dónde se derivo el trámite
                            'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                            'observacion' => Libreria::getParam($request->input('observacion')),
                        ]);

                        $tramite->update([
                            'situacion' => 'RECHAZADO AREA ANTERIOR',
                        ]);
                    } else {
                        $seguimiento = Seguimiento::create([
                            'fecha' => date("Y-m-d H:i:s"),
                            'accion' => 'RECHAZAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                            'correlativo' => $correlativo_anterior + 1,
                            'correlativo_anterior' => $correlativo_anterior,
                            'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                            'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                            'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                            'tramite_id' => $id,
                            'personal_id' => $usuario['id'],
                            'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                            'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                            'motivorechazo_id' => $request->motivorechazo_id,
                            'observacion' => Libreria::getParam($request->input('observacion')),
                        ]);
                        //luego se finaliza
                        $seguimiento = Seguimiento::create([
                            'fecha' => date("Y-m-d H:i:s"),
                            'accion' => 'FINALIZAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                            'correlativo' => $correlativo_anterior + 2,
                            'correlativo_anterior' => $correlativo_anterior + 1,
                            'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                            'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                            'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                            'tramite_id' => $id,
                            'personal_id' => $usuario['id'],
                            'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                            'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                            'motivorechazo_id' => $request->motivorechazo_id,
                            'observacion' => Libreria::getParam($request->input('observacion')),
                            'ultimo' => 'S',
                        ]);
                        $tramite->update([
                            'situacion' => 'FINALIZADO CON OBSERVACION',
                        ]);
                    }
                    break;
                case 'finalizar':
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento = Seguimiento::create([
                        'fecha' => date("Y-m-d H:i:s"),
                        'accion' => 'FINALIZAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior + 1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'motivorechazo_id' => $request->motivorechazo_id,
                        'observacion' => Libreria::getParam($request->input('observacion')),
                        'ultimo' => 'S',
                    ]);
                    $tramite->update([
                        'situacion' => 'FINALIZADO',
                        'archivador_id' => $request->input('archivador') ? Libreria::getParam($request->input('archivador')) : null
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
                    $seguimiento = Seguimiento::create([
                        'fecha' => date("Y-m-d H:i:s"),
                        'accion' => 'DERIVAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior + 1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>   $usuario['area'] ? $usuario['area']['descripcion'] : null, //el última área que hizo la accion de derivar
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $area['id'], //id_area a dónde se derivo el trámite
                        'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion' => Libreria::getParam($request->input('observacion')),
                    ]);
                    $tramite->update([
                        'situacion' => 'DERIVADO',
                    ]);
                    break;
                case 'adjuntar':
                    $reglas     = array('archivo' => 'required', 'observacion' => 'required');
                    $mensajes = array(
                        'archivo.required' => 'Debe ingresar un archivo',
                        'observacion.required' => 'Debe ingresar un observacion sobre el archivo',
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }
                    $extension = $request->file('archivo')->getClientOriginalExtension();
                    $archivo = $request->file('archivo')->storeAs('public/archivos', time() .  '.' . $extension);
                    $ruta = Storage::url($archivo);
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento = Seguimiento::create([
                        'fecha' => date("Y-m-d H:i:s"),
                        'accion' => 'ADJUNTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior + 1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                        'tramite_id' => $id,
                        'ruta' => $ruta,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion' => Libreria::getParam($request->input('observacion')),
                    ]);
                    break;
                case 'seguimiento':
                    break;
                case 'comentar':
                    $reglas     = array('observacion' => 'required');
                    $mensajes = array(
                        'observacion.required' => 'Debe ingresar un observacion sobre el archivo',
                    );
                    $validacion = Validator::make($request->all(), $reglas, $mensajes);
                    if ($validacion->fails()) {
                        return $validacion->messages()->toJson();
                    }
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento = Seguimiento::create([
                        'fecha' => date("Y-m-d H:i:s"),
                        'accion' => 'COMENTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior + 1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion' => Libreria::getParam($request->input('observacion')),
                    ]);
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
                        'archivador_id' => $request->archivador_id,
                    ]);
                    $ultimo_seguimiento = Seguimiento::where('tramite_id', $id)->orderBy('id', 'desc')->first();
                    $correlativo_anterior = $ultimo_seguimiento->correlativo;
                    $seguimiento = Seguimiento::create([
                        'fecha' => date("Y-m-d H:i:s"),
                        'accion' => 'COMENTAR',  // REGISTRAR , ACEPTAR , DERIVAR , RECHAZAR
                        'correlativo' => $correlativo_anterior + 1,
                        'correlativo_anterior' => $correlativo_anterior,
                        'area' =>  $usuario['area'] ? $usuario['area']['descripcion'] : null,
                        'cargo' => $usuario['cargo'] ? $usuario['cargo']['descripcion'] : null,
                        'persona' => $usuario['nombres'] . ' ' . $usuario['apellidopaterno'] . ' ' . $usuario['apellidomaterno'],
                        'tramite_id' => $id,
                        'personal_id' => $usuario['id'],
                        'area_id'  => $usuario['area'] ? $usuario['area']['id'] : null,
                        'cargo_id' => $usuario['cargo'] ? $usuario['cargo']['id'] : null,
                        'observacion' => Libreria::getParam($request->input('observacion'), 'ARCHIVANDO DOC.'),
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
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        $tipo = 'MANUAL';
        return view($this->folderview . '.mant')->with(compact('tipo', 'tramite', 'formData', 'entidad', 'boton', 'listar'));
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
        $error = DB::transaction(function () use ($request, $id) {
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
        $error = DB::transaction(function () use ($id) {
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
        $formData = array('route' => array('tramite.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function listarProcedimientos(Request $request)
    {
        $q = $request->input('term');
        $user = Auth::user();
        $area_inicio = $user->personal ? $user->personal->area_id : "";
        $resultados = Procedimiento::where('descripcion', 'LIKE', '%' . $q . '%');
        // if($area_inicio && $area_inicio!= ""){
        //     $resultados->where('areainicio_id',$area_inicio);
        // }
        $resultados = $resultados->get();
        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = ["text" => $r->descripcion, "id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarEmpresascourier(Request $request)
    {
        $q = $request->input('term');

        $resultados = Empresacourier::where(function ($query) use ($q) {
            $query->where('razonsocial', 'LIKE', '%' . $q . '%')
                ->orWhere('ruc', 'LIKE', '%' . $q . '%');
        })->get();

        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = ["text" => $r->ruc . '-' . $r->razonsocial, "id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarAreas(Request $request)
    {
        $q = $request->input('term');
        $resultados = Area::where('descripcion', 'LIKE', '%' . $q . '%')->get();

        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = ["text" => $r->descripcion, "id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarArchivadores(Request $request)
    {
        $q = $request->input('term');

        $resultados = Archivador::where(function ($query) use ($q) {
            $query->where('descripcion', 'LIKE', '%' . $q . '%')
                ->orWhere('codigo', 'LIKE', '%' . $q . '%');
        })->get();
        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = ["text" => $r->codigo . '-' . $r->descripcion, "id" => $r->id];
        }
        return  \json_encode($data);
    }

    public function listarTramites(Request $request)
    {
        $q = $request->input('term');

        $resultados = Tramite::where('numero', 'LIKE', '%' . $q . '%')->get();
        $data = array();
        foreach ($resultados as $r) {
            $data["results"][] = ["text" => $r->numero, "id" => $r->id];
        }
        return  \json_encode($data);
    }
    public function listarremitentes(Request $request)
    {
        $q = $request->input('term');

        $area_id = session()->all()['personal']['area']['id'];
        $resultados = Personal::where(function ($subquery) use ($q, $area_id) {
            if (!is_null($q)) {
                $subquery
                    ->where(DB::raw('concat(personal.apellidopaterno,\' \',personal.apellidomaterno,\' \',personal.nombres)'), 'LIKE', '%' . $q . '%');
            }
        })->where('area_id', $area_id)->get();
        $data = array();
        foreach ($resultados as $r) {
            $nombres = $r->nombres . " " . $r->apellidopaterno . " " . $r->apellidomaterno;
            $data["results"][] = ["text" => $nombres, "id" => $nombres];
        }
        return  \json_encode($data);
    }

    public function listarPersonal(Request $request)
    {
        $q = $request->input('query');
        $mesapartes =  session()->all()['personal']['area']['mesadepartes'];
        if ($mesapartes == 1) {
            $resultados = Personal::where(function ($subquery) use ($q) {
                if (!is_null($q)) {
                    $subquery->where(DB::raw('concat(personal.apellidopaterno,\' \',personal.apellidomaterno,\' \',personal.nombres)'), 'LIKE', '%' . $q . '%');
                }
            })->get();
        } else {
            $area_id = session()->all()['personal']['area']['id'];
            $resultados = Personal::where(function ($subquery) use ($q, $area_id) {
                if (!is_null($q)) {
                    $subquery
                        ->where(DB::raw('concat(personal.apellidopaterno,\' \',personal.apellidomaterno,\' \',personal.nombres)'), 'LIKE', '%' . $q . '%');
                }
            })->where('area_id', $area_id)->get();
        }
        $data = array();
        foreach ($resultados as $r) {
            $nombre = $r->apellidopaterno . ' ' . $r->apellidomaterno . ' ' . $r->nombres;
            $data[] = strtoupper($nombre);
        }


        return  \json_encode($data);
    }


    public function generarNumero(Request $request)
    {
        $año           = date('Y');
        $numerotramite = Tramite::NumeroSigue($año);
        echo $año . "-" . $numerotramite;
    }

    public function generarTicket(Request $request)
    {
        $id = $request->ticket;
        $tramite = Tramite::with('tipodocumento', 'procedimiento', 'seguimientos')->find($id);
        $data = $tramite;
        $customPaper = array(0, 0, 567.00, 283.80);
        $pdf = PDF::loadView('gestion.tramite.ticket', compact('data'))->setPaper($customPaper, 'landscape');
        $nombre = 'Ticket Nro. :' . $data->numero . '-' . $data->fecha . '.pdf';
        return $pdf->stream($nombre);
    }
}
