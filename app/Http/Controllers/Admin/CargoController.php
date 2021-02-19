<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Cargo;

class CargoController extends Controller
{
    public function index(){
        return view('admin.cargo.index');
    }
    
    public function getCargos(){
        $nacionalidad = Cargo::orderBy('descripcion')->get()->toArray();
        $data = [];
        $loop=1; 

        foreach ($nacionalidad as $item) {
            $data[]=[
                'nombre'=>$item['descripcion'],
                'id'=>$item['id']
            ];
            $loop++;
        }
        return response()->json(array('data' => $data));
    }

    public function show($id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('admin.cargo.show', compact('cargo'));
    }

    public function update(Request $request)
    {

        try {
            $id = $request->numero_id;
            $cargo = Cargo::findOrFail($id);
            $cargo->update([
                'descripcion' => strtoupper($request->descripcion2),
            ]);
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

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $cargo = Cargo::with('personal')->findOrFail($id)->toArray();
                return response()->json(['data' => $cargo, 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Ha ocurrido un error', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'descripcion' => 'required',
        ]);
 
        try {
            $cargo = Cargo::create([
                'descripcion' => strtoupper($request->descripcion),
            ]);
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
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                Cargo::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}
