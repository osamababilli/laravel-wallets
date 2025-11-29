<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoWalle extends Model
{
    protected $fillable = [
        'name',
        'address',
        'status',
    ];
}
