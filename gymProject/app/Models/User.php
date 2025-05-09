<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Suscripcion;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = ['nombre','correo','password'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime'];

    public function username()
    {
        return 'correo';
    }

    /**
     * Relación: devuelve la SUSCRIPCIÓN ACTIVA más reciente (o null si no hay).
     */
    public function suscripcion()
    {
        return $this->hasOne(Suscripcion::class, 'usuario_id')
                    ->where('estado', 'activo')
                    ->latestOfMany('fecha_inicio');
    }
}
