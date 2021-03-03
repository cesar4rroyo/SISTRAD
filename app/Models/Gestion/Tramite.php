<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tramite extends Model
{
	use SoftDeletes;
    protected $table = 'tramite';
    protected $dates = ['deleted_at'];

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'tramite_id');
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

    public function scopelistar($query, $numero, $fecinicio, $fecfin)
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
			->orderBy('numero', 'ASC');
	}
}
