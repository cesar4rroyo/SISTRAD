<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\GrupoMenu;
use App\Models\Admin\OpcionMenu;

class OpcionMenuController extends Controller
{
    public function index()
    {
        $grupomenu = GrupoMenu::get()->toArray();
        return view('admin.opcionmenu.index', compact('grupomenu'));
    }

    public function getOpciones()
    {
        $opcion = OpcionMenu::with('grupomenu')->orderBy('id')->get()->toArray();
        $data = [];
        foreach ($opcion as $item) {
            $data[] = [
                'id' => $item['id'],
                'nombre' => $item['descripcion'],
                'link' => $item['link'],
                'icono' => $item['icono'],
                'orden' => $item['orden'],
                'grupo' => $item['grupomenu']['descripcion'],

            ];
        }
        return response()->json(array('data' => $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
            'link' => 'required',
        ]);

        try {
            $opcion = OpcionMenu::create([
                'descripcion' => $request->nombre,
                'link' => $request->link,
                'orden' => $request->orden,
                'icono' => $request->icono,
                'grupomenu_id' => $request->grupomenu_id
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
        $opcionmenu = OpcionMenu::findOrFail($id);
        return view('admin.opcionmenu.show', compact('opcionmenu'));
    }


    public function edit(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->id;
                $opcion = OpcionMenu::with('grupomenu')->findOrFail($id)->toArray();
                return response()->json(['data' => $opcion, 'type' => 'success']);
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
            $opcion = OpcionMenu::findOrFail($id);
            $opcion->update([
                'descripcion' => $request->nombre2,
                'link' => $request->link2,
                'orden' => $request->orden2,
                'icono' => $request->icono2,
                'grupomenu_id' => $request->grupomenu_id2
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
                OpcionMenu::destroy($id);
                return response()->json(['message' => 'Se ha eliminado correctamente', 'type' => 'success']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No se puede eliminar, ya que hay un recurso más usando este elemento ', 'type' => 'error']);
            }
        } else {
            abort(404);
        }
    }
}
