<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Librerias\Libreria;
use App\Models\Control\Subtipotramitenodoc;
use App\Models\Control\Tipotramitenodoc;
use App\Models\Gestion\Resolucion;

class ReporteResolucionController extends Controller
{
    protected $folderview      = 'reportes';
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $entidad          = 'resolucionreporte';
        $tipos            = [""=>'Todos'] + Tipotramitenodoc::pluck('descripcion','id')->all();
        $subtipos = [""=>'Todos'] + Subtipotramitenodoc::pluck('descripcion', 'id')->all();
        return view($this->folderview . '.adminresolucion')->with(compact('entidad' , 'tipos', 'subtipos'));
    }

    public function pdfResolucion(Request $request)
    {   
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $subtipo             = Libreria::getParam($request->input('subtipo'));
        $resultado        = Resolucion::whereHas('tipotramite' ,function ($subquery) use ($tipo) {
                                if (!is_null($tipo) && strlen($tipo) > 0) {
                                    $subquery->where('id', '=' , $tipo);
                                }
                            })->whereHas('subtipo' ,function ($subquery) use ($subtipo) {
                                if (!is_null($subtipo) && strlen($subtipo) > 0) {
                                    $subquery->where('id', '=' , $subtipo);
                                }
                            })->where(function ($subquery) use ($fecinicio) {
                                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                                    $subquery->where('resolucion.fechaexpedicion', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
                                }
                            })
                            ->where(function ($subquery) use ($fecfin) {
                                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                                    $subquery->where('resolucion.fechaexpedicion', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
                                }
                            })
                            ->orderBy('created_at','ASC');
                
        $lista1            = $resultado->get();

       
        $pdf = PDF::loadView('reportes.pdfResolucion', compact('lista1' , 'fecinicio' , 'fecfin'))->setPaper('a4','landscape');
        return $pdf->stream('pdfResolucion.pdf');
    }
}
