<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Control\Area;
use App\Models\Gestion\Tramite;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class ReportetramiteController extends Controller
{
    protected $folderview      = 'reportes';
   

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $entidad          = 'tramitereporte';
        $areas            = [""=>'Todas'] + Area::pluck('descripcion','id')->all();
        return view($this->folderview . '.admin')->with(compact('entidad' , 'areas'));
    }

    public function pdfTramites(Request $request)
    {   
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $area             = Libreria::getParam($request->input('area'));
        $resultado        = Tramite::whereHas('seguimientos' ,function ($subquery) use ($area) {
                                    if (!is_null($area) && strlen($area) > 0) {
                                        $subquery->where('area_id', '=' , $area)->where('accion','REGISTRAR');
                                    }
                                })
                            ->where(function ($subquery) use ($tipo) {
                                if (!is_null($tipo) && strlen($tipo) > 0) {
                                    $subquery->where('tramite.tipo', $tipo);
                                }
                            })
                            ->where(function ($subquery) use ($fecinicio) {
                                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                                    $subquery->where('tramite.fecha', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
                                }
                            })
                            ->where(function ($subquery) use ($fecfin) {
                                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                                    $subquery->where('tramite.fecha', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
                                }
                            })
                            ->orderBy('created_at','ASC');
                
        $lista1            = $resultado->get();
       
        $pdf = PDF::loadView('reportes.pdftramites', compact('lista1' , 'fecinicio' , 'fecfin'))->setPaper('a4','landscape');
        //$guia = $request->input('guia');

        //HOJA HORIZONTAL ->setPaper('a4', 'landscape')
    //descargar
       // return $pdf->download('F'.$cotizacion->documento->correlativo.'.pdf');  
    //Ver
       return $pdf->stream('reporteclientes.pdf');
    }
}
