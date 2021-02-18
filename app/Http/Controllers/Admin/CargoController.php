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
    
    public function getNacionalidades(){
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
}
