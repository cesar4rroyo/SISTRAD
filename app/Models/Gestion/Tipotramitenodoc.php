<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Tipotramitenodoc extends Model
{
	use SoftDeletes;
    protected $table = 'tipotramitenodoc';
    protected $dates = ['deleted_at'];


    
}
