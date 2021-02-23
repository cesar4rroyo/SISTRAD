<?php

namespace App\Models\Admin;

use App\Models\Control\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Personal extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'personal';
    protected $fillable = [
        'dni',
        'apellidopaterno',
        'apellidomaterno',
        'nombres',
        'dni',
        'direccion',
        'telefono',
        'email',
        'area_id',
        'cargo_id'
    ];
    //funciones para el mantenimiento
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rolpersonal');
    }

    public function usuario()
    {
        return $this->hasMany(Usuario::class);
    }
}
