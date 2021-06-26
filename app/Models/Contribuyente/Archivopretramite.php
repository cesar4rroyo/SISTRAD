<?php

namespace App\Models\Contribuyente;

use App\Models\Admin\Personal;
use App\Models\Control\Infraccion;
use App\Models\Gestion\Seguimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archivopretramite extends Model
{
	use SoftDeletes;
    protected $table = 'archivopretramite';
    protected $dates = ['deleted_at'];

    
    public function pretramite()
    {
        return $this->belongsTo(Pretramite::class, 'pretramite_id');
    }
    
}
