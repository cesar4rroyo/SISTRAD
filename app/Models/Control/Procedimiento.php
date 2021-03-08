<?php

namespace App\Models\Control;

use App\Models\Gestion\Tramite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedimiento extends Model
{
	use SoftDeletes;
    protected $table = 'procedimiento';
    protected $dates = ['deleted_at'];


    public function areainicio()
    {
        return $this->belongsTo('App\Models\Control\Area', 'areainicio_id');
    }
    public function areafin()
    {
        return $this->belongsTo('App\Models\Control\Area', 'areafin_id');
    }

    public function rutas()
    {
        return $this->hasMany('App\Models\Control\Rutaprocedimiento', 'procedimiento_id');
    }

    public function tramite()
    {
        return $this->hasMany(Tramite::class, 'procedimiento_id');
    }
}
