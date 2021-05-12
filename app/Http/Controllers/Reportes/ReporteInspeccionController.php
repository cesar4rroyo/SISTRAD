<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gestion\Tipotramitenodoc;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Librerias\Libreria;
use App\Models\Gestion\Inspeccion;

class ReporteInspeccionController extends Controller
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
        $entidad          = 'inspeccionreporte';
        $tipos            = [""=>'Todos'] + Tipotramitenodoc::pluck('descripcion','id')->all();
        return view($this->folderview . '.adminInspeccion')->with(compact('entidad' , 'tipos'));
    }

    public function pdfInspeccion(Request $request)
    {   
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $observacion             = Libreria::getParam($request->input('observacion'));
        $resultado        = Inspeccion::with('carta')->whereHas('tipotramite' ,function ($subquery) use ($tipo) {
                                if (!is_null($tipo) && strlen($tipo) > 0) {
                                    $subquery->where('id', '=' , $tipo);
                                }
                            })
                            ->where(function ($subquery) use ($fecinicio) {
                                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                                    $subquery->where('inspeccion.fecha', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
                                }
                            })
                            ->where(function ($subquery) use ($observacion) {
                                if (!is_null($observacion) && strlen($observacion) > 0) {
                                    $subquery->where('inspeccion.estado', '=' ,$observacion);
                                }
                            })
                            ->where(function ($subquery) use ($fecfin) {
                                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                                    $subquery->where('inspeccion.fecha', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
                                }
                            })
                            ->orderBy('created_at','ASC');
                
        $lista1            = $resultado->get();
        $has_observacion=false;
        if(!is_null($observacion) && strlen($observacion) > 0){
            if($observacion=='OBSERVADO' || $observacion=='NOTIFICADO'){
                $has_observacion=true;
            }
        }
       
        $pdf = PDF::loadView('reportes.pdfinspeccion', compact('lista1' , 'fecinicio' , 'fecfin', 'has_observacion'))->setPaper('a4','landscape');
        return $pdf->stream('pdfinspeccion.pdf');
    }
}
