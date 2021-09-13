<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Requests;
use App\Models\Gestion\Tramite;
use App\Librerias\Libreria;
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

class BuscarTramiteController extends Controller
{
    protected $folderview      = 'gestion.tramitegeneral';
    protected $tituloAdmin     = 'Búsqueda General de Trámites';
    protected $tituloRegistrar = 'Registrar';
    protected $tituloModificar = 'Modificar';
    protected $tituloEliminar  = 'Eliminar';
    protected $rutas           = array('create' => 'tramitegeneral.create', 
            'edit'   => 'tramitegeneral.edit', 
            'delete' => 'tramitegeneral.eliminar',
            'search' => 'tramitegeneral.buscar',
            'index'  => 'anio.index',
            'accion'=>'tramitegeneral.accion',
            'confirmacion'=>'tramite.confirmacion',
            'printseguimiento'=>'tramite.printseguimiento'
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
        $modo             = 'general';
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $numero           = Libreria::getParam($request->input('numero'));
        $remitente        = Libreria::getParam($request->input('remisor'));
        $resultado        = Tramite::listar3($numero , $fecinicio, $fecfin, $modo, $area_id, $personal_id, $tipo, $remitente);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Prioridad', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nro. Seguim.', 'numero' => '1');
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
            $cboTipoTramite  = [""=>'Todos', 'TUPA'=>'Tupa', 'INTERNO'=>'Interno']; 
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta','area_id', 'area_actual', 'cboTipoTramite'));
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
        $entidad          = 'tramite';
        $cboTipoTramite  = [""=>'Todos', 'TUPA'=>'Tupa', 'INTERNO'=>'Interno']; 
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $mesapartes =  session()->all()['personal']['area']['mesadepartes'];
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboTipoTramite', 'mesapartes'));
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

    public function listarPersonal(Request $request){
        $q = $request->input('query');

        $resultados = Personal::where(function ($subquery) use ($q) {
            if (!is_null($q)) {
                $subquery->where(DB::raw('concat(personal.apellidopaterno,\' \',personal.apellidomaterno,\' \',personal.nombres)'), 'LIKE', '%' . $q . '%');
            }
        })->get();
        $data = array();
        foreach ($resultados as $r) {
            $nombre = $r->apellidopaterno.' '.$r->apellidomaterno.' '.$r->nombres;
            $data[] = strtoupper($nombre);
        }
        return  \json_encode($data);
    }

    
    

}
