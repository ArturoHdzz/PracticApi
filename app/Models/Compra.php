<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable = ['fecha', 'total', 'metodo_pago_id', 'user_id'];
    protected $table = 'compras';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function detallecompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }


}
