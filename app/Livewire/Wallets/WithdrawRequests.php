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
            // Logic for approval:
            // Since balance was deducted at request time (in WithdrawPage),
            // approval basically confirms the external transfer was done.
            // We might want to just update status.
            $request->status = 'approved';
            $request->user->withdraw($request->amount);
            $request->save();

            notify(__('تم تأكيد طلب السحب بنجاح'), 'success', false);
        }
    }

    public function rejectRquest($id)
    {
        $request = WithdrawRequest::find($id);
        if ($request && $request->status == 'pending') {
            // Logic for rejection:
            // Refund the user.
            $request->user->balance += $request->amount;
            $request->user->save();

            $request->status = 'rejected';
            $request->save();

            notify(__('Withdraw Request Rejected Successfully and Refunded'), 'success', false);
        }
    }

    public function render()
    {
        $requests = $this->getdata();
        return view('livewire.wallets.withdraw-requests', compact('requests'));
    }
}
