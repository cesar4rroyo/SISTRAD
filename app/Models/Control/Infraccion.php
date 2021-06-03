<?php

namespace App\Models\Control;

use App\Models\Admin\Personal;
use App\Models\Gestion\Seguimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infraccion extends Model
{
	use SoftDeletes;
    protected $table = 'infraccion';
    protected $dates = ['deleted_at'];

    
}
