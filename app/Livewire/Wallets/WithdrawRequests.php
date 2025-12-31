<?php

namespace App\Livewire\Wallets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WithdrawRequest;

class WithdrawRequests extends Component
{
    use WithPagination;

    public function getdata()
    {
        if (auth()->user()->hasRole('super admin')) {
            return $this->ForAdmin();
        } else {
            return $this->ForUser();
        }
    }

    public function ForUser()
    {
        return WithdrawRequest::where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(20);
    }

    public function ForAdmin()
    {
        return WithdrawRequest::with('user')->orderBy('created_at', 'desc')->paginate(20);
    }

    public function acceptRquest($id)
    {
        $request = WithdrawRequest::find($id);
        if ($request && $request->status == 'pending') {

            $request->status = 'approved';

            $request->save();


            $net_amount = $request->amount + $request->amount * 0.01;
            $request->user->wallets()->first()->withdraw($net_amount);
            notify(__('تم تأكيد طلب السحب بنجاح'), 'success', false);
        }
    }

    public function rejectRquest($id)
    {
        $request = WithdrawRequest::find($id);
        if ($request && $request->status == 'pending') {



            $request->status = 'rejected';
            $request->save();

            notify(__('تم رفض طلب السحب بنجاح'), 'success', false);
        }
    }

    public function render()
    {
        $requests = $this->getdata();
        return view('livewire.wallets.withdraw-requests', compact('requests'));
    }
}
