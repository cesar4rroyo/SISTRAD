<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\GrupoMenu;

class GrupoMenuController extends Controller
{
    public function index()
    {
        return view('admin.grupomenu.index');
    }
    public function getGrupos()
    {
        $grupos = GrupoMenu::with('opcionmenu')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($grupos as $item) {

            $data[] = [
                'id' => $item['id'],
                'nombre' => $item['descripcion'],
                'icono' => $item['icono'],
                'orden' => $item['orden'],

            ];
        }
        return response()->json(array('data' => $data));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
        ]);

        try {
            $tipousuario = GrupoMenu::create([
                'descripcion' => $request->descripcion,
                'icono' => $request->icono,
                'orden' => $request->orden,
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
        $grupomenu = GrupoMenu::findOrFail($id);
        return view('admin.grupomenu.show', compact('grupomenu'));
    }


    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $grupo = GrupoMenu::with('opcionmenu')->findOrFail($id)->toArray();
                return response()->json(['data' => $grupo, 'type' => 'success']);
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
            $tipo = GrupoMenu::findOrFail($id);
            $tipo->update([
                'descripcion' => $request->descripcion2,
                'icono' => $request->icono2,
                'orden' => $request->orden2,
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
                GrupoMenu::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}
