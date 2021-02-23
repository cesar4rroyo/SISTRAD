<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Usuario extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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

     /**
     * Función para listar Usuarios
     *
     * @param  model $query
     * @param  string $login
     * @param  string $nombre
     * @param  int $tipousuario
     * @param  int $area
     * @param  int $cargo     * 
     * @return sql 
     */
    public function scopelistar($query, $login, $nombre = null, $tipousuario_id = null, $area_id = null, $cargo_id = null)
    {
        return $query->join('personal', 'personal.id', '=', 'usuario.personal_id')

            ->where(function ($subquery) use ($login) {
                if (!is_null($login)) {
                    $subquery->where('login', 'LIKE', '%' . $login . '%');
                }
            })
            ->where(function ($subquery) use ($nombre) {
                if (!is_null($nombre)) {
                    $subquery->where(DB::raw('concat(person.apellidopaterno,\' \',person.apellidomaterno,\' \',person.nombres)'), 'LIKE', '%' . $nombre . '%');
                }
            })
            ->where(function ($subquery) use ($tipousuario_id) {
                if (!is_null($tipousuario_id)) {
                    $subquery->where('tipousuario_id', '=', $tipousuario_id);
                }
            }) 
            ->where(function ($subquery) use ($cargo_id){
                if (!is_null($cargo_id)) {
                    $subquery->where('cargo_id', '=', $cargo_id);
                }
            })
            ->where(function ($subquery) use ($area_id){
                if (!is_null($area_id)) {
                    $subquery->where('area_id', '=', $area_id);
                }
            })          
            ->select('usuario.*', 'personal.nombres', 'personal.apellidopaterno', 'personal.apellidomaterno')->orderBy('personal.apellidopaterno', 'asc');
    }
}
