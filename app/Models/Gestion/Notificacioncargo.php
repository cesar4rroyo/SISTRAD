<?php

namespace App\Models\Gestion;

use App\Models\Admin\Personal;
use App\Models\Control\Infraccion;
use App\Models\Gestion\Seguimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacioncargo extends Model
{
	use SoftDeletes;
    protected $table = 'notificacioncargo';
    protected $dates = ['deleted_at'];

    
    public function actainspeccion()
    {
        return $this->belongsTo(Acta::class, 'actafiscalizacion_id');
    }
    public function infraccion()
    {
        return $this->belongsTo(Infraccion::class, 'infraccion_id');
    }
    public function descargos()
    {
        return $this->hasMany(Descargonotificacion::class, 'notificacion_id');
    }
    public function detalles()
    {
        return $this->hasMany(Detallenotificacion::class, 'notificacion_id');
    }


    public function scopelistar($query, $numero, $fecinicio, $fecfin,$estado)
	{
		return $query
            ->where(function ($subquery) use ($numero) {
				if (!is_null($numero) && strlen($numero) > 0) {
					$subquery->where('numero', 'LIKE', '%'.$numero.'%');
				}
			})
			->where(function ($subquery) use ($fecinicio) {
				if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
					$subquery->where('fecha_notificacion', '>=', date_format(date_create($fecinicio), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($fecfin) {
				if (!is_null($fecfin) && strlen($fecfin) > 0) {
					$subquery->where('fecha_notificacion', '<=', date_format(date_create($fecfin), 'Y-m-d H:i:s'));
				}
			})
			->where(function ($subquery) use ($estado) {
				if (!is_null($estado) && strlen($estado) > 0) {
					$subquery->where('estado', $estado);
				}
			})
			
			->orderBy('created_at', 'DESC');
	}
}
