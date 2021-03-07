<?php

namespace App\Models\Gestion;

use App\Models\Admin\Personal;
use App\Models\Control\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguimiento extends Model
{
	use SoftDeletes;
    protected $table = 'seguimiento';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'correlativo', 
        'correlativo_anterior', 
        'fecha', 
        'accion', 
        'observacion',
        'ultimo',
        'area',
        'cargo',
        'persona',
        'recibido',
        'fecha_recibe',
        'tiposeguimiento',
        'ruta',
        'tramite_id',
        'personal_id',
        'area_id',
        'motivocourier_id',
        'motivorechazo_id',
        'cargo_id'        
    ];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function areas()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

   
}
