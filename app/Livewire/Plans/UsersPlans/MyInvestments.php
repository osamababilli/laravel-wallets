<?php

namespace App\Livewire\Plans\UsersPlans;

use App\Models\Member;
use App\Models\ProfitWithdrawal;
use Livewire\Component;
use App\Models\WalletRequest;

class MyInvestments extends Component
{




    public function withdrawProfit($id, $amount)
    {

        $user = auth()->user();

        // $user->deposit($amount);


        ProfitWithdrawal::create([
            'amount' => $amount,
            'member_id' => $id,
            'user_id' => $user->id,
            'status' => 'pending',

        ]);


        // Logic to handle deposit action
        notify(__('Withdraw request submitted successfully'), 'success', false);
    }

    public function leaveInvestment($id, $amount)
    {

        $investment = Member::find($id);
        if ($investment) {
            $investment->update([
                'last_withdrawal_at' => now()
            ]);
            $investment->save();
        }

        if (!$investment) {
            notify(__('Investment Not Found'), 'warning', false);
            return;
        }

        if ($amount > 0) {
            WalletRequest::create([
                'amount' => $amount,
                'type' => 'withdraw',
                'status' => 'pending',
                'user_id' => auth()->user()->id,
            ]);
        }




        $investment->delete();
        notify('Investment left successfully', 'success', false);
    }
    public function GetData()
    {

        return Member::where('user_id', auth()->user()->id)->get();
    }
    public function render()
    {
        $inverstments = $this->GetData();
        return view('livewire.plans.users-plans.my-investments', compact('inverstments'));
    }
}
