<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresacourier extends Model
{
	 use SoftDeletes;
    protected $table = 'empresacourier';
    protected $dates = ['deleted_at'];
}
