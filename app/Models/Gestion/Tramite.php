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

    public function scopelistar($query, $numero, $fecinicio, $fecfin, $modo=null, $area_actual=null, $personal_id)
	{
		return $query->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
				}
			})
			->where(function ($subquery) use ($fecinicio) {
				if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
					$subquery->where('fecha', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('fecha', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
				}
			})
            ->when($modo, function($q) use ($modo, $area_actual, $personal_id){
                switch ($modo) {
                    case 'entrada':
                        $q->wherehas('seguimientos', function($q2) use($area_actual){
                            return $q2->latest()->where('area_id', $area_actual)->whereNull('recibido');
                            // return $q2->where('area_id', $area_actual)->whereNull('recibido');
                        })->whereIn('situacion', ['REGISTRADO', 'DERIVADO']);
                        break;
                    case 'bandeja':
                        $q->wherehas('seguimientos', function($q2) use($area_actual, $personal_id){
                            return $q2->latest()->where('area_id', $area_actual)
                                    ->where('accion', 'ACEPTAR');
                        })->whereNotIn('situacion', ['FINALIZADO', 'RECHAZADO', 'REGISTRADO', 'DERIVADO']);
                        break;
                    case 'salida':
                        $q->wherehas('seguimientos', function($q2) use($area_actual, $personal_id){
                            return $q2->latest()->where('area_id', $area_actual)
                                    ->whereIn('accion', ['FINALIZAR', 'DERIVAR', 'RECHAZAR']);
                        })->whereIn('situacion', ['DERIVADO', 'FINALIZADO', 'RECHAZADO']);
                        break;
                    case 'general':
                        $q->wherehas('seguimientos', function($q2) use ($area_actual){
                            return $q2->where('area_id', $area_actual);
                        });
                        break;
                    case 'archivos':
                        $q->wherehas('seguimientos', function($q2) use ($area_actual){
                            return $q2->where('area_id', $area_actual)
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
