<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
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
