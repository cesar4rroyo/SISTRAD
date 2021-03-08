<?php

namespace App\Models\Gestion;

use App\Models\Control\Procedimiento;
use App\Models\Control\Tipodocumento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tramite extends Model
{
	use SoftDeletes;
    protected $table = 'tramite';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    protected $fillable = [
        'remitente', 
        'formarecepcion', 
        'situacion', 
        'observacion', 
        'asunto',
        'numero',
        'tipo',
        'fecha',
        'prioridad',
        'tipodocumento_id',
        'procedimiento_id',
        'personal_id',
        'archivador_id',
        'motivorechazo_id',
        'empresacourier_id',
        'tramiteref_id',
    ];


    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'tramite_id');
    }
    public function tipodocumento()
    {
        return $this->belongsTo(Tipodocumento::class);
    }
    public function procedimiento()
    {
        return $this->belongsTo(Procedimiento::class);
    }
    public function areaactual(){
        $ultimoseguimiento = $this->join('seguimiento as s','s.tramite_id', 'tramite.id')
                        ->where('tramite.id',$this->id)
                        ->whereNull('s.deleted_at')
                        ->orderBy('s.correlativo', 'DESC')
                        ->first();
        if($ultimoseguimiento){
            return $ultimoseguimiento->area;
        }else{
            return "";
        }
    }
    public function areaorigen(){
        $ultimoseguimiento = $this->join('seguimiento as s','s.tramite_id', 'tramite.id')
                        ->where('tramite.id',$this->id)
                        ->whereNull('s.deleted_at')
                        ->orderBy('s.correlativo', 'ASC')
                        ->first();
        if($ultimoseguimiento){
            return $ultimoseguimiento->area;
        }else{
            return "";
        }
    }
    public function ultimo()
    {
        return $this->join('seguimiento as s','s.tramite_id', 'tramite.id')
        ->where('tramite.id',$this->id)
        ->whereNull('s.deleted_at')
        ->orderBy('s.correlativo', 'ASC')
        ->first();   
    }
    public function latestSeguimiento()
    {
        return $this->hasOne(Seguimiento::class)->orderBy('correlativo', 'desc')->latest();
    }

    public function scopelistar($query, $numero, $fecinicio, $fecfin, $modo=null, $area_actual=null, $personal_id)
	{
		return $query->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
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
            ->when($modo, function($q) use ($modo){
                $usuario = session()->get('personal');
                $area_id = $usuario['area_id'];
                switch ($modo) {
                    case 'entrada':  
                        return $q->join('seguimiento', 'tramite.id', '=', 'seguimiento.tramite_id')
                                ->select('tramite.*', 'seguimiento.*')
                                ->where('area_id', $area_id)
                                ->whereIn('accion', ['DERIVAR', 'REGISTRAR'])
                                ->whereIn('situacion', ['REGISTRADO', 'DERIVADO'])
                                ->orderBy('correlativo', 'desc')->first();
                        break;
                    case 'bandeja':
                        return $q->join('seguimiento', 'tramite.id', '=', 'seguimiento.tramite_id')
                                ->select('tramite.*', 'seguimiento.*')
                                ->where('area_id', $area_id)
                                ->where('accion', 'ACEPTAR')
                                ->where('situacion', 'EN PROCESO')
                                ->orderBy('correlativo', 'DESC')
                                ->first();
                        break;
                    case 'salida':
                        return $q->join('seguimiento', 'tramite.id', '=', 'seguimiento.tramite_id')
                                ->select('tramite.*', 'seguimiento.*')
                                ->where('area_id', $area_id)
                                ->whereIn('accion', ['DERIVAR', 'FINALIZAR', 'ACEPTAR'])
                                ->whereIn('situacion', ['DERIVADO, FINALIZADO, RECHAZADO'])
                                ->orderBy('correlativo', 'DESC')
                                ->first();
                        break;
                    case 'general':
                        $q->whereHas('seguimientos', function($q2) use ($area_id){
                            return $q2->where('area_id', $area_id);
                        });
                        break;
                    case 'archivos':
                        $q->wherehas('seguimientos', function($q2) use ($area_id){
                            return $q2->where('area_id', $area_id)
                                    ->whereNotNull('ruta');
                        });
                        break;
                    case 'courier':
                        $q->whereNotNull('empresacourier_id');
                        break;

                }
            })
			->orderBy('numero', 'ASC');
	}
}
