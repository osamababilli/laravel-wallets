<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class WalletRequest extends Model

{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
        'status',
        'user_id'
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
