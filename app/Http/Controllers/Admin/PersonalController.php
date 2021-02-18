<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Area;
use App\Models\Admin\Cargo;
use App\Models\Admin\Personal;
use App\Models\Admin\Rol;

class PersonalController extends Controller
{
    public function index()
    {
        $roles = Rol::orderBy('id')->pluck('descripcion', 'id')->toArray();
        $cargos = Cargo::with('personal')->get();
        $areas = Area::with('personal')->get();
        return view('admin.persona.index', compact('roles', 'cargos', 'areas'));
    }

    public function getPersonas()
    {
        $persona = Personal::with('cargo', 'area')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($persona as $item) {
            $data[] = [
                'id' => $item['id'],
                'dni' => $item['dni'],
                'apellidopaterno' => $item['apellidopaterno'],
                'apellidomaterno' => $item['apellidomaterno'],
                'nombres' => $item['nombres'],
                'direccion' => $item['direccion'],
                'telefono' => $item['telefono'],
                'email' => $item['email'],
                'cargo' => $item['cargo']['descripcion'],
                'area' => $item['area']['descripcion'],
            ];
        }
        return response()->json(array('data' => $data));
    }

  
    public function store(Request $request)
    {

        /* $this->validate($request, [
            'dni' => 'nullable|numeric|unique:persona,dni,' . 'id',
            'ruc' => 'nullable|numeric|unique:persona,ruc,' . 'id',
        ]); */

        try {
            $persona = Personal::create([
                'nombres' => strtoupper($request->nombres),
                'apellidopaterno' => strtoupper($request->apellidopaterno),
                'apellidomaterno' => strtoupper($request->apellidomaterno),
                'direccion' => strtoupper($request->direccion),
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'cargo_id' => $request->cargo_id,
                'area_id' => $request->area_id,
                'email' => $request->email,
            ]);
            $persona->roles()->sync($request->rol_id);

            return response()->json([
                'message' => 'Se agregado correctamente',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ha ocurrido un error ' . $th->getMessage(),
                'type' => 'error'
            ]);
        }
    }



    public function show($id)
    {
        $persona = Personal::findOrFail($id);
        return view('admin.persona.show', compact('persona'));
    }


    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $persona = Personal::with('roles', 'area', 'cargo')->findOrFail($id)->toArray();
                $roles = [];
                if (count($persona['roles']) != 0) {
                    foreach ($persona['roles'] as $item) {
                        $roles[] =
                            $item['id'];
                    }
                }
                return response()->json(['persona' => $persona, 'roles' => $roles]);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Ha ocurrido un error', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }


    public function update(Request $request)
    {

        try {
            $id = $request->numeroPersona;
            $persona = Personal::findOrFail($id);
            $persona->update([
                'nombres' => strtoupper($request->nombres),
                'apellidopaterno' => strtoupper($request->apellidopaterno),
                'apellidomaterno' => strtoupper($request->apellidomaterno),
                'direccion' => strtoupper($request->direccion),
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'cargo_id' => $request->cargo_id,
                'area_id' => $request->area_id,
                'email' => $request->email,
            ]);
            $persona->roles()->sync($request->rol_id2);
            return response()->json([
                'message' => 'Se ha actualizado correctamente',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ha ocurrido un error ' . $th->getMessage(),
                'type' => 'error'
            ]);
        }
    }


    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                Personal::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}
