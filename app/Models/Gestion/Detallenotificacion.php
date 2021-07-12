<?php

namespace App\Models\Gestion;

use App\Models\Admin\Personal;
use App\Models\Control\Infraccion;
use App\Models\Gestion\Seguimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detallenotificacion extends Model
{
	use SoftDeletes;
    protected $table = 'detallenotificacion';
    protected $dates = ['deleted_at'];

    
    public function notificacion()
    {
        return $this->belongsTo(Notificacioncargo::class, 'notificacion_id');
    }
    public function infraccion()
    {
        return $this->belongsTo(Infraccion::class, 'infraccion_id');
    }
    
}
