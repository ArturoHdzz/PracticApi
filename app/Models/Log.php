<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;

class Log extends Model
{
    use HasFactory;
    protected $collection = 'logs_collection';
    protected $connection = 'mongodb';

    protected $fillable = ['route', 'method', 'values', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}