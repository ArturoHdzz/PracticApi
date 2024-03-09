<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];
    protected $table = 'catalogos';

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
