<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];
    protected $table = 'roles';

    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}
