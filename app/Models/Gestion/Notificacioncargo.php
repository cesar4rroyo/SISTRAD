<?php

namespace App\Models\Gestion;

use App\Models\Admin\Personal;
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
}
