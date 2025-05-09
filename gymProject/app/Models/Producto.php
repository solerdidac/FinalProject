<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'stock',
        'categoria', 'imagen', 'fecha_creacion'
    ];
}