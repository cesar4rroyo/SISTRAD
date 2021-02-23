<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Personal;
use App\Models\Admin\TipoUsuario;
use App\Models\Admin\Usuario;
use TipoUsuarioSeeder;
use Validator;
use App\Librerias\Libreria;
use App\Models\Admin\Cargo;
use App\Models\Control\Area;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    protected $folderview      = 'admin.usuario';
    protected $tituloAdmin     = 'Usuario';
    protected $tituloRegistrar = 'Registrar usuario';
    protected $tituloModificar = 'Modificar usuario';
    protected $tituloEliminar  = 'Eliminar usuario';
    protected $rutas           = array('create' => 'usuario.create', 
            'edit'   => 'usuario.edit', 
            'delete' => 'usuario.eliminar',
            'search' => 'usuario.buscar',
            'index'  => 'usuario.index',
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

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Usuario';
        $login            = Libreria::getParam($request->input('login'));
        $nombre           = Libreria::getParam($request->input('nombre'));
        $tipousuario_id   = Libreria::getParam($request->input('tipousuario_id'));
        $area_id          = Libreria::getParam($request->input('area_id'));
        $cargo_id         = Libreria::getParam($request->input('cargo_id'))     ;
        $resultado        = Usuario::listar($login,$nombre,$tipousuario_id, $area_id, $cargo_id);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Login', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo de usuario', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Personal', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cargo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Área', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');
        
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
        $entidad          = 'Usuario';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboTiposUsuario  = array('' => 'TODOS') + TipoUsuario::pluck('descripcion', 'id')->all();
        $cboAreas = ['' => 'TODAS'] + Area::pluck('descripcion', 'id')->all();
        $cboCargos = ['' => 'TODOS'] + Cargo::pluck('descripcion', 'id')->all();

        
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta','cboTiposUsuario', 'cboAreas', 'cboCargos'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar       = Libreria::getParam($request->input('listar'), 'NO');
        $entidad      = 'usuario';
        $cboTiposUsuario  = array('' => 'Seleccione un Tipo de Usuario') + TipoUsuario::pluck('descripcion', 'id')->all();
        $usuario   = null;
        $formData     = array('usuario.store');
        $personal = Personal::all()->toArray();
        $cboPersonal =  array('' => 'Seleccione una Persona') + Personal::get()->pluck('full_name', 'id')->all();;
        $formData     = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton        = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('usuario', 'formData', 'entidad', 'boton', 'cboTiposUsuario', 'listar', 'cboPersonal'));
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
        $reglas = array(
            'login'       => 'required|max:20|unique:user,login,NULL,id,deleted_at,NULL',
            'password'    => 'required|max:20',
            'tipousuario_id' => 'required|integer|exists:tipousuario,id,deleted_at,NULL',
            'personal_id'   => 'required|integer|exists:personal,id,deleted_at,NULL',
            );

        $mensajes = array(
            'login.required' => 'Debe ingresar el nombre de usuario.',
            'password.required' => 'Debe ingresar una contraseña.',
            'tipousuario_id.required' => 'Debe seleccionar un tipo de usuario.',
            'personal_id.required' => 'Debe seleccionar una persona.',
        );
       
        $validacion = Validator::make($request->all(),$reglas,$mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $usuario = Usuario::create([
                'login'=>  $request->input('login'),
                'password'=> Hash::make($request->input('password')),
                'tipousuario_id'=> $request->input('tipousuario_id'),
                'personal_id'=> $request->input('personal_id'),
            ]);            
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
        $existe = Libreria::verificarExistencia($id, 'usuario');
        if ($existe !== true) {
            return $existe;
        }
        $listar         = Libreria::getParam($request->input('listar'), 'NO');
        $usuario        = Usuario::find($id);
        $entidad        = 'usuario';
        $formData       = array('usuario.update', $id);
        $formData       = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton          = 'Modificar';
        $cboTiposUsuario  = array('' => 'Seleccione un Tipo de Usuario') + TipoUsuario::pluck('descripcion', 'id')->all();
        $cboPersonal =  array('' => 'Seleccione una Persona') + Personal::get()->pluck('full_name', 'id')->all();;
        return view($this->folderview.'.mant')->with(compact('usuario', 'formData', 'entidad', 'boton', 'listar', 'cboTiposUsuario', 'cboPersonal'));
    }



    
}
