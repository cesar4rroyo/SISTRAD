<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Librerias\Libreria;
use App\Models\Control\Area;
use App\Models\Control\Subtipotramitenodoc;
use App\Models\Control\Tipotramitenodoc;
use App\Models\Gestion\Ordenpago;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class ReporteordenpagoController extends Controller
{
    protected $folderview      = 'reportes.pagos';
   

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
        $entidad          = 'ordenpagoreporte';
        $tipostramite     = ["" => 'Todos' ] + Tipotramitenodoc::pluck('descripcion' , 'id')->all();
        $subtipostramite     = ["" => 'Todos' ] + Subtipotramitenodoc::pluck('descripcion' , 'id')->all();
        return view($this->folderview . '.admin')->with(compact('entidad'  , 'tipostramite','subtipostramite'));
    }

    public function pdfordenespago(Request $request)
    {   
        $fecinicio        = Libreria::getParam($request->input('fechainicio'));
        $fecfin           = Libreria::getParam($request->input('fechafin'));
        $tipo             = Libreria::getParam($request->input('tipo'));
        $subtipo             = Libreria::getParam($request->input('subtipo'));
        $estado             = Libreria::getParam($request->input('estado'));
        $resultado        = Ordenpago::listar(null, $fecinicio,$fecfin, null , $tipo,$subtipo ,$estado);
        $lista1            = $resultado->get();
       
        $pdf = PDF::loadView($this->folderview.'.pdfordenpagos', compact('lista1' , 'fecinicio' , 'fecfin'))->setPaper('a4','landscape');
        //$guia = $request->input('guia');

        //HOJA HORIZONTAL ->setPaper('a4', 'landscape')
    //descargar
       // return $pdf->download('F'.$cotizacion->documento->correlativo.'.pdf');  
    //Ver
       return $pdf->stream('reportepagos.pdf');
    }
}
