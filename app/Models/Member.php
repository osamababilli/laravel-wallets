<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'last_withdrawal_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }



    public function profitWithdrawals()
    {
        return $this->hasMany(ProfitWithdrawal::class);
    }

    // دالة لحساب آخر سحب معتمد
    public function lastApprovedWithdrawal()
    {
        return $this->profitWithdrawals()
            ->where('status', 'approved')
            ->latest('approved_at')
            ->first();
    }


    // دالة لحساب الأرباح الحالية
    public function getCurrentProfit()
    {
        $profit = $this->plan->profit;
        $type = $this->plan->type;

        // حساب الساعات من تاريخ الاشتراك
        $hoursPassed = $this->created_at->diffInHours(now());

        // حساب إجمالي الربح المتراكم
        $totalAccumulatedProfit = match ($type) {
            'daily' => $profit * floor($hoursPassed / 24),
            'weekly' => $profit * floor($hoursPassed / 168),
            'monthly' => $profit * floor($hoursPassed / 720),
            'yearly' => $profit * floor($hoursPassed / 8760),
            default => 0,
        };

        // طرح مجموع السحوبات المعتمدة
        $totalWithdrawn = $this->profitWithdrawals()
            ->where('status', 'approved')
            ->sum('amount');

        // الربح المتاح = الربح المتراكم - المسحوب
        $availableProfit = $totalAccumulatedProfit - $totalWithdrawn;

        return max(0, $availableProfit); // لا يمكن أن يكون سالب
    }
}
