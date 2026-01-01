<?php

namespace App\Livewire\Members\ProfitWithdrawals;

use Livewire\Component;
use App\Models\ProfitWithdrawal;
use Livewire\WithPagination;

class ProfitWithdrawalsList extends Component
{

    use WithPagination;




    public function acceptRquest($id)
    {
        $request = ProfitWithdrawal::find($id);
        if ($request) {
            $request->status = 'approved';
            $request->save();
            notify(__('Wallet Request Approved Successfully'), 'success', false);
        }
    }
    public function rejectRquest($id)
    {
        $request = ProfitWithdrawal::find($id);
        if ($request) {
            $request->status = 'rejected';
            $request->save();
            notify(__('Wallet Request Rejected Successfully'), 'success', false);
        }
    }


    public function GetData()
    {

        if (auth()->user()->hasRole('super admin')) {
            return $this->ForAdmin();
        } else {
            return $this->ForUser();
        }
    }


    public function ForAdmin()
    {
        return ProfitWithdrawal::latest()->paginate(30);
    }
    public function ForUser()
    {
        return auth()->user()->profitWithdrawals()->latest()->paginate(30);
    }

    public function render()
    {
        $history = $this->GetData();
        return view('livewire.members.profit-withdrawals.profit-withdrawals-list', compact('history'));
    }
}
