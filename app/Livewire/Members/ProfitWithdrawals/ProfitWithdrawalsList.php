<?php

namespace App\Livewire\Members\ProfitWithdrawals;

use Livewire\Component;
use App\Models\ProfitWithdrawal;
use Livewire\WithPagination;

class ProfitWithdrawalsList extends Component
{

    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';


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
        $query = ProfitWithdrawal::query()->with(['user', 'investment']);

        if ($this->search) {
            $this->resetPage();
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('user_number', 'like', '%' . $this->search . '%');
            });
        }
        return $query->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }
    public function ForUser()
    {
        return auth()->user()->profitWithdrawals()->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }

    public function render()
    {
        $history = $this->GetData();
        return view('livewire.members.profit-withdrawals.profit-withdrawals-list', compact('history'));
    }
}
