<?php

namespace App\Http\Controllers\Gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResolucionController extends Controller
{
    protected $folderview      = 'gestion.resolucion';
    protected $tituloAdmin     = 'Resolución';
    protected $tituloRegistrar = 'Registrar Resolución';
    protected $tituloModificar = 'Modificar Resolución';
    protected $tituloEliminar  = 'Eliminar Resolución';
    protected $rutas           = array(
        'create' => 'resolucion.create',
        'edit'   => 'resolucion.edit',
        'delete' => 'resolucion.eliminar',
        'search' => 'resolucion.buscar',
        'index'  => 'resolucion.index',
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
        $entidad          = 'resolucion';
        $nombres          = Libreria::getParam($request->input('nombres'));
        $dni              = Libreria::getParam($request->input('dni'));
        $area_id          = Libreria::getParam($request->input('area'));
        $cargo_id         = Libreria::getParam($request->input('cargo'));
        $resultado        = resolucion::listar($nombres, $dni, $area_id, $cargo_id);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Apellidos y Nombres', 'numero' => '1');
        $cabecera[]       = array('valor' => 'DNI', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Direccion', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Telefono', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Correo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Cargo', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Area', 'numero' => '1');
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
            return view($this->folderview . '.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
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
        $entidad          = 'resolucion';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboAreas = ['' => 'TODAS'] + Area::pluck('descripcion', 'id')->all();
        $cboCargos = ['' => 'TODOS'] + Cargo::pluck('descripcion', 'id')->all();
        $cboRol = [''=>'TODOS'];
        $rol = Rol::orderBy('descripcion', 'asc')->get();
        foreach ($rol as $k => $v) {
            $cboRol = $cboRol + array($v->id => $v->descripcion);
        }
        return view($this->folderview . '.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta', 'cboAreas', 'cboCargos', 'cboRol'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'resolucion';
        $persona = null;
        $formData = array('persona.store');
        $cboAreas = ['' => 'Seleccione un área'] + Area::pluck('descripcion', 'id')->all();
        $cboCargos = ['' => 'Seleccione un cargo'] + Cargo::pluck('descripcion', 'id')->all();
        $roles = Rol::orderBy('id')->pluck('descripcion', 'id')->toArray();        
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        return view($this->folderview . '.mant')->with(compact('persona', 'formData', 'entidad', 'boton', 'listar', 'roles', 'cboAreas', 'cboCargos'));
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
            'nombres' => 'required|max:50',
            'dni' => 'required|numeric|min:10000000|max:99999999|unique:resolucion,dni,' . 'id',
            'apellidopaterno' => 'required|max:50',
            'apellidomaterno' => 'required|max:50',
            'rol_id' => 'required',
            'area_id'=>'required',
            'cargo_id'=>'required',
        );
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre',
            'apellidopaterno.required'         => 'Debe ingresar el apellido paterno',
            'apellidomaterno.required'         => 'Debe ingresar el apellido materno',
            'rol_id.required'         => 'Debe seleccionar al menos un Rol',
            'dni.unique'=>'La persona con el DNI ingresado ya se encuentra registrado',
            'dni.required'=>'El campo DNI es obligatorio',
            'dni.min'=>'El DNI es incorrecto',
            'dni.max'=>'El DNI es incorrecto',
            'cargo_id.required'=>'El campo Cargo es obligatorio',
            'area_id.required'=>'El campo Área es obligatorio',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function () use ($request) {
            $persona = resolucion::create([
                'apellidopaterno' => strtoupper($request->input('apellidopaterno')),
                'apellidomaterno' => strtoupper($request->input('apellidomaterno')),
                'nombres' => strtoupper($request->input('nombres')),
                'dni' => strtoupper($request->input('dni')),           
                'ruc' => strtoupper($request->input('ruc')),           
                'direccion' => strtoupper($request->input('direccion')),
                'email' => $request->input('email'),       
                'telefono' => strtoupper($request->input('telefono')),
                'cargo_id' => $request->input('cargo_id'),       
                'area_id' => $request->input('area_id'),      
            ]);
            $persona->roles()->sync($request->rol_id);
            
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
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $persona = resolucion::find($id);
        $roles = Rol::orderBy('id')->pluck('descripcion', 'id')->toArray();        
        $cboAreas = ['' => 'Seleccione un área'] + Area::pluck('descripcion', 'id')->all();
        $cboCargos = ['' => 'Seleccione un cargo'] + Cargo::pluck('descripcion', 'id')->all();
        $entidad  = 'resolucion';
        $formData = array('persona.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento' . $entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview . '.mant')->with(compact('persona', 'formData', 'entidad', 'boton', 'listar', 'roles', 'cboAreas', 'cboCargos'));
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
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $reglas     = array(
            'nombres' => 'required|max:50',
            'apellidopaterno' => 'required|max:50',
            'apellidomaterno' => 'required|max:50',
            'rol_id' => 'required',
            'area_id'=>'required',
            'cargo_id'=>'required',
        );
        $mensajes = array(
            'nombre.required'         => 'Debe ingresar un nombre',
            'apellidopaterno.required'         => 'Debe ingresar el apellido paterno',
            'apellidomaterno.required'         => 'Debe ingresar el apellido materno',
            'rol_id.required'         => 'Debe seleccionar al menos un Rol',
            'dni.unique'=>'La persona con el DNI ingresado ya se encuentra registrado',
            'dni.required'=>'El campo DNI es obligatorio',
            'dni.min'=>'El DNI es incorrecto',
            'dni.max'=>'El DNI es incorrecto',
            'cargo_id.required'=>'El campo Cargo es obligatorio',
            'area_id.required'=>'El campo Área es obligatorio',
        );
        $validacion = Validator::make($request->all(), $reglas, $mensajes);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function () use ($request, $id) {
            $persona = resolucion::find($id);
            $persona->update([
                'apellidopaterno' => strtoupper($request->input('apellidopaterno')),
                'apellidomaterno' => strtoupper($request->input('apellidomaterno')),
                'nombres' => strtoupper($request->input('nombres')),
                'dni' => strtoupper($request->input('dni')),           
                'ruc' => strtoupper($request->input('ruc')),           
                'direccion' => strtoupper($request->input('direccion')),
                'email' => $request->input('email'),       
                'telefono' => strtoupper($request->input('telefono')),
                'cargo_id' => $request->input('cargo_id'),       
                'area_id' => $request->input('area_id'), 
            ]);
            $persona->roles()->sync($request->rol_id);
            
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
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function () use ($id) {
            $resolucion = resolucion::find($id);
            $resolucion->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'resolucion');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = resolucion::find($id);
        $entidad  = 'resolucion';
        $formData = array('route' => array('persona.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('reusable.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
}