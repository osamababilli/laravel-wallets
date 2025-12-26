<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitWithdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'amount',
        'status',

    ];


    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investment()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
