<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseña extends Model
{
    use HasFactory;
    protected $fillable = ['comentario', 'calificacion', 'fecha' ,'modelo_id', 'user_id'];
}
