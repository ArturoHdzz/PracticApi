<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'stock', 'precio' ,'catalogo_id'];
    protected $table = 'items';

    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class);
    }

    public function modelo()
    {
        return $this->HasMany(Modelo::class);
    }
}
