<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Usuario extends Authenticatable
{
    protected $remember_token = 'false';
    protected $table = 'usuario';
    protected $fillable = [
        'login',
        'password',
        'personal_id',
        'tipousuario_id'
    ];
     //funciones para el manteniemto

     public function personal()
     {
         return $this->belongsTo(Personal::class, 'personal_id');
     }
     public function tipousuario()
     {
         return $this->belongsTo(TipoUsuario::class, 'tipousuario_id');
     }
     public function setSession($tipousuario)
     {
         if (count($tipousuario) == 1) {
             Session::put([
                 'tipousuario_id' => $tipousuario[0]['id'],
                 'tipousuario_nombre' => $tipousuario[0]['descripcion'],
                 'usuario' => $this->login,
                 'accesos' => $this->tipousuario()->with('opcionmenu')->get()->toArray()[0]['opcionmenu'] ?? null,
                 'usuario_id' => $this->id,
                 'personal' => $this->personal()->get()->toArray()[0] ?? null,
                 'roles' => $this->personal()->with('roles')->get()->toArray()[0]['roles'] ?? null,
             ]);
         }
     }
     public function setPasswordAttribute($password)
     {
         $this->attributes['password'] = Hash::make($password);
     }
 
     public static function getPersonasUsuarios()
     {
         $id_rolUsuario = '1';
         $personas = Personal::whereHas('roles', function ($query) use ($id_rolUsuario) {
             $query->where('rol.id', '=', $id_rolUsuario);
         })->get();
         return $personas;
     }
}
