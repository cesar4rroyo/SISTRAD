<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GrupoMenu extends Model
{
    protected $table = 'grupomenu';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion', 'icono', 'orden'];
    public function opcionmenu()
    {
        return $this->hasMany(OpcionMenu::class, 'grupomenu_id');
    }
}
