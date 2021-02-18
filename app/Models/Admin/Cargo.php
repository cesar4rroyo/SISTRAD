<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];

    public function personal()
    {
        return $this->hasMany(Personal::class, 'cargo_id');
    }
}
