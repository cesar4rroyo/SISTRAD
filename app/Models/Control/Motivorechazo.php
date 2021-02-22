<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motivorechazo extends Model
{
	 use SoftDeletes;
    protected $table = 'motivorechazo';
    protected $dates = ['deleted_at'];
}
