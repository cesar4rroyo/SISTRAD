<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];

    public function personal()
    {
        return $this->hasMany(Personal::class, 'area_id');
    }
}
