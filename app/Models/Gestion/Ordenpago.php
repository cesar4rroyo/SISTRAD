<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordenpago extends Model
{
	use SoftDeletes;
    protected $table = 'ordenpago';
    protected $dates = ['deleted_at'];



    public function scopelistar($query, $numero, $fecinicio, $fecfin, $contribuyente, $tipo)
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
			->where(function ($subquery) use ($tipo) {
				if (!is_null($tipo) && strlen($tipo) > 0) {
					$subquery->where('tipo', 'LIKE', '%'.$tipo.'%');
				}
			})
			->where(function ($subquery) use ($contribuyente) {
				if (!is_null($contribuyente) && strlen($contribuyente) > 0) {
					$subquery->where('contribuyente', 'LIKE', '%'.$contribuyente.'%')
                            ->orWhere('dni_ruc', 'LIKE', '%'.$contribuyente.'%');
				}
			})
			->orderBy('created_at', 'DESC');
	}
}
