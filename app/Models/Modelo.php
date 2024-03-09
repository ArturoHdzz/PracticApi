<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion','item_id'];
    protected $table = 'modelos';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function detallecompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function reseña()
    {
        return $this->hasMany(Reseña::class);
    }

    public function detallepedido()
    {
        return $this->hasMany(DetallePedido::class);
    }   

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }
}
