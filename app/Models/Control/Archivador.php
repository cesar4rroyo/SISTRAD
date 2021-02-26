<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archivador extends Model
{
	use SoftDeletes;
    protected $table = 'archivador';
    protected $dates = ['deleted_at'];

   
}
