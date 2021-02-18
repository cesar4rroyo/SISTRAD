<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];

    public function personal()
    {
        return $this->belongsToMany(Personal::class, 'rolpersonal');
    }
}
