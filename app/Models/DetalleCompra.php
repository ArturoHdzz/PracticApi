<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $fillable = ['cantidad', 'precio', 'subtotal','compra_id', 'modelo_id'];
    protected $table = 'detalle_compras';

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    
}
