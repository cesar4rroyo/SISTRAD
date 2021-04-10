<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Resolucion extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'resolucion';
    protected $fillable = [
        'fecha',
        'tipo',
        'numero',
        'contribuyente',
        'direccion',
        'dni',
        'ruc',
        'observaciones',
        'inspeccion_id',
        'ordenpago_id'
    ];
    /* public function ordenpago()
    {
        return $this->belongsTo(Ordenpago::class, 'ordenpago_id');
    }
    public function inspeccion()
    {
        return $this->hasOne(Inspeccion::class, 'inspeccion_id');
    } */
}
