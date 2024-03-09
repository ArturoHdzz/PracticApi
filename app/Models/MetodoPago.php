<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'tipo'];
    protected $table = 'metodo_pagos';

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

}
