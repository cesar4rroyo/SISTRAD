<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seguimiento extends Model
{
	use SoftDeletes;
    protected $table = 'seguimiento';
    protected $dates = ['deleted_at'];

   
}
