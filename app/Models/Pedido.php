<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = ['fecha', 'total', 'direccion','metodo_pago_id', 'user_id'];
    protected $table = 'pedidos';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function detallepedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

}
