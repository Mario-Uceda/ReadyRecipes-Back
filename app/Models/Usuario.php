<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'usuarios';
    protected $hidden = [
        'pass',
        // 'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {

        return ["user"=>$this];
    }
    public function is_admin()
    {
        return $this->administrador == 1;
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_Usuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_Usuario');
    }
}
