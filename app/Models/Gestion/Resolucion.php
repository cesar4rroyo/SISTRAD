<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Resolucion extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'resolucion';
    protected $fillable = [
        'fechaexpedicion',
        'fechavencimiento',
        'tipo',
        'numero',
        'contribuyente',
        'direccion',
        'dni',
        'ruc',
        'observaciones',
        'inspeccion_id',
        'ordenpago_id',
		'localidad',
		'zona',
		'categoria',
		'girocomercial',
		'razonsocial',
		'tipo_id',
		'uso',
		'altura',
		'proyecto',
		'area',
		'valor',
		'responsableobra'
    ];
    public function ordenpago()
    {
        return $this->belongsTo(Ordenpago::class, 'ordenpago_id');
    }
	public function tipotramite()
    {
        return $this->belongsTo(Tipotramitenodoc::class, 'tipo_id');
    }
    public function inspeccion()
    {
        return $this->belongsTo(Inspeccion::class, 'inspeccion_id');
    }
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
					$subquery->where('fechaexpedicion', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('fechaexpedicion', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($tipo) {
				if (!is_null($tipo) && strlen($tipo) > 0) {
					$subquery->where('tipo_id', 'LIKE', '%'.$tipo.'%');
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
	public function scopeNumeroSigue($query , $tipo)
	{
			$rs = $query
				->where(function ($subquery) use ($tipo) {
					if (!is_null($tipo) && strlen($tipo) > 0) {
						$subquery->where('tipo_id', $tipo);
					}
				})->select(DB::raw("max((CASE WHEN numero IS NULL THEN 0 ELSE convert(substr(numero,1,8),SIGNED  integer) END)*1) AS maximo"))->first();
		
        return str_pad($rs->maximo + 1, 8, '0', STR_PAD_LEFT);
	}
}
