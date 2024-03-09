<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'modelo_id', 'fecha'];
    protected $table = 'favoritos';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
}
