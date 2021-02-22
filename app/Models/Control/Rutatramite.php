<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rutatramite extends Model
{
	 use SoftDeletes;
    protected $table = 'rutatramite';
    protected $dates = ['deleted_at'];


    public function areainicio()
    {
        return $this->belongsTo('App\Models\Control\Area', 'areainicial_id');
    }
    public function areafin()
    {
        return $this->belongsTo('App\Models\Control\Area', 'areafinal_id');
    }
    public function tramite()
    {
        return $this->belongsTo('App\Models\Control\Tramite', 'tramite_id');
    }
}
