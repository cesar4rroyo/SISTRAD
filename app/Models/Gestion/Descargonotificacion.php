<?php

namespace App\Models\Gestion;

use App\Models\Admin\Personal;
use App\Models\Control\Infraccion;
use App\Models\Gestion\Seguimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descargonotificacion extends Model
{
	use SoftDeletes;
    protected $table = 'descargonotificacion';
    protected $dates = ['deleted_at'];

    
    public function notificacion()
    {
        return $this->belongsTo(Notificacioncargo::class, 'notificacion_id');
    }
    
}
