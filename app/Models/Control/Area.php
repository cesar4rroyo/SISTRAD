<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
	 use SoftDeletes;
    protected $table = 'area';
    protected $dates = ['deleted_at'];
}
