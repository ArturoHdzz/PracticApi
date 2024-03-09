<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $fillable = ['cantidad', 'precio', 'subtotal','pedido_id', 'modelo_id'];
    protected $table = 'detalle_pedidos';

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
    
}
