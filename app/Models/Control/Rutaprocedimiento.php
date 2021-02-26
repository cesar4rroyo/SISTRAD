<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rutaprocedimiento extends Model
{
	 use SoftDeletes;
    protected $table = 'rutaprocedimiento';
    protected $dates = ['deleted_at'];


    public function areainicio()
    {
        return $this->belongsTo('App\Models\Control\Area', 'areainicial_id');
    }
    public function areafin()
    {
        return $this->belongsTo('App\Models\Control\Area', 'areafinal_id');
    }
    public function procedimiento()
    {
        return $this->belongsTo('App\Models\Control\Procedimiento', 'procedimiento_id');
    }
}
