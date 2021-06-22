<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ResolucionSancion extends Model
{
    use SoftDeletes;
    protected $table = 'resolucionsancion';
    protected $dates = ['deleted_at'];

	public function notificacion(){
		return $this->belongsTo(Notificacioncargo::class, 'notificacioncargo_id');
	}
	public function actafiscalizacion(){
		return $this->belongsTo(Acta::class, 'actafiscalizacion_id');
	}

	public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'resolucionsancion_id');
    }

	public function ultimo()
    {
        return $this->join('seguimiento as s','s.resolucionsancion_id', 'resolucionsancion.id')
        ->where('resolucionsancion.id',$this->id)
        ->whereNull('s.deleted_at')
        ->orderBy('s.correlativo', 'DESC')
        ->first();   
    }
    
    public function latestSeguimiento()
    {
        return $this->hasOne(Seguimiento::class)->orderBy('correlativo', 'desc')->latest();
    }
    public function firstSeguimiento()
    {
        return $this->hasOne(Seguimiento::class)->orderBy('correlativo', 'asc')->latest();
    }

    public function scopelistar($query, $numero, $fecinicio, $fecfin, $estado=null)
	{
		return $query
            ->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
				}
			})
			->where(function ($subquery) use ($estado) {
				if (!is_null($estado) && strlen($estado) > 0) {
					$subquery->where('estado', 'LIKE', '%'.$estado.'%');
				}
			})
			->where(function ($subquery) use ($fecinicio) {
				if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
					$subquery->where('fechaemision', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('fechaemision', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
				}
			})
			->orderBy('created_at', 'DESC');
	}

    public function scopeNumeroSigue($query)
	{
			$rs = $query->select(DB::raw("max((CASE WHEN numero IS NULL THEN 0 ELSE convert(substr(numero,6,11),SIGNED  integer) END)*1) AS maximo"))->first();
		
        return str_pad($rs->maximo + 1, 11, '0', STR_PAD_LEFT);
	}
}
