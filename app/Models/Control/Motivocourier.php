<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motivocourier extends Model
{
	 use SoftDeletes;
    protected $table = 'motivocourier';
    protected $dates = ['deleted_at'];
}
