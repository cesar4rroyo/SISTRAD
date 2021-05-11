<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Subtipotramitenodoc extends Model
{
	use SoftDeletes;
    protected $table = 'subtipotramitenodoc';
    protected $dates = ['deleted_at'];

    public function tipotramite()
    {
        return $this->belongsTo('App\Models\Control\Tipotramitenodoc', 'tipotramitenodoc_id');
    }
}
