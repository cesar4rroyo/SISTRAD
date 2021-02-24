<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tramite extends Model
{
	use SoftDeletes;
    protected $table = 'tramite';
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
        return $this->hasMany('App\Models\Control\Rutatramite', 'tramite_id');
    }
}
