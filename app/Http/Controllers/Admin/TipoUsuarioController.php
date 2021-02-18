<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\TipoUsuario;

class TipoUsuarioController extends Controller
{
    public function index()
    {
        $tipousuario = TipoUsuario::orderBy('id')->pluck('descripcion', 'id')->toArray();
        return view('admin.tipousuario.index', compact('tipousuario'));
    }

    public function getTipos()
    {
        $tipos = TipoUsuario::with('usuario')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($tipos as $item) {
            if ($item['id'] != 1) {
                $data[] = [
                    'id' => $item['id'],
                    'nombre' => $item['descripcion'],
                ];
            }
        }
        return response()->json(array('data' => $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
        ]);

        try {
            $tipousuario = TipoUsuario::create([
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


    public function show($id)
    {
        $tipousuario = TipoUsuario::findOrFail($id);
        return view('admin.tipousuario.show', compact('tipousuario'));
    }


    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $tipo = TipoUsuario::with('usuario')->findOrFail($id)->toArray();
                return response()->json(['data' => $tipo, 'type' => 'success']);
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
            $id = $request->numero_id;
            $tipo = TipoUsuario::findOrFail($id);
            $tipo->update([
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


    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                TipoUsuario::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}
