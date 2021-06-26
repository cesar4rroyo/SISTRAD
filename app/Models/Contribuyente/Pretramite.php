<?php

namespace App\Models\Contribuyente;

use App\Models\Admin\Personal;
use App\Models\Control\Infraccion;
use App\Models\Gestion\Seguimiento;
use App\Models\Gestion\Tramite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pretramite extends Model
{
	use SoftDeletes;
    protected $table = 'pretramite';
    protected $dates = ['deleted_at'];

    
   
    public function archivos()
    {
        return $this->hasMany(Archivopretramite::class, 'pretramite_id');
    }
    public function tramite()
    {
        return $this->hasOne(Tramite::class, 'pretramite_id');
    }


    public function scopelistar($query, $numero, $fecinicio, $fecfin, $remitente ,$estado)
	{
		return $query
            ->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
				}
			})
			->where(function ($subquery) use ($fecinicio) {
				if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
					$subquery->where('created_at', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('created_at', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($estado) {
				if (!is_null($estado) && strlen($estado) > 0) {
					$subquery->where('estado', $estado);
				}
			})
			->where(function ($subquery) use ($remitente) {
				if (!is_null($remitente) && strlen($remitente) > 0) {
					$subquery->where('remitente', 'LIKE', '%'.$remitente.'%')
                            ->orWhere('dni', 'LIKE', '%'.$remitente.'%');
				}
			})
			->orderBy('created_at', 'DESC');
	}

	public function scopeNumeroSigue($query )
	{
			$rs = $query->select(DB::raw("max((CASE WHEN numero IS NULL THEN 0 ELSE convert(substr(numero,1,8),SIGNED  integer) END)*1) AS maximo"))->first();
		
        return str_pad($rs->maximo + 1, 8, '0', STR_PAD_LEFT);
	}
}
