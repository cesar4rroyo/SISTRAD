<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PadronFiscalizacion extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'padronfiscalizacion';
    protected $primaryKey = 'id';

    public function scopelistar($query, $numero, $fecinicio, $fecfin, $contribuyente)
	{
		return $query
            ->where(function ($subquery) use ($numero) {
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
            ->where(function ($subquery) use ($contribuyente) {
				if (!is_null($contribuyente) && strlen($contribuyente) > 0) {
					$subquery->where('razonsocial', 'LIKE', '%'.$contribuyente.'%')
                            ->orWhere('representante', 'LIKE', '%'.$contribuyente.'%')
                            ->orWhere('direccion', 'LIKE', '%'.$contribuyente.'%')
                            ->orWhere('ruc', 'LIKE', '%'.$contribuyente.'%');
				}
			})
			->orderBy('created_at', 'DESC');
	}

    public function scopeNumeroSigue($query)
	{
            $año=date('y');
			$rs = $query
				->select(DB::raw("max((CASE WHEN numero IS NULL THEN 0 ELSE convert(substr(numero,6,11),SIGNED  integer) END)*1) AS maximo"))->first();
		
        return str_pad($rs->maximo + 1, 11, '0', STR_PAD_LEFT);
	}
}
