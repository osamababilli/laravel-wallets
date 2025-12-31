<?php

namespace App\Livewire;

use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Flux\Flux;

class WithdrawPage extends Component
{
    public $amount;
    public $network;
    public $wallet_address;
    public $password;

    public $networks = ['TRX', 'BNB', 'POLYGON', 'ETH']; // Simplified list


    protected function messages()
    {
        return [
            'amount.required' => 'الالمبلغ مطلوبة',
            'amount.numeric' => 'الالمبلغ يجب أن تكون رقم',
            'amount.min' => 'الالمبلغ يجب أن تكون أكبر من 1',
            'amount.max' => 'الالمبلغ يجب أن تكون أقل من ' . auth()->user()->balance,
            'network.required' => 'الشبكة مطلوبة',
            'wallet_address.required' => 'عنوان المحفظة مطلوب',
            'wallet_address.string' => 'عنوان المحفظة يجب أن يكون نص',
            'wallet_address.min' => 'عنوان المحفظة يجب أن يكون أطول من 10',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => 'كلمة المرور يجب أن يكون نص',
            'password.min' => 'كلمة المرور يجب أن يكون أطول من 6',
        ];
    }
    public function withdraw()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1|max:' . auth()->user()->balance,
            'network' => 'required',
            'wallet_address' => 'required|string|min:10',
            'password' => 'required',
        ]);





        // Check password (assuming user login password for now)
        if (!Hash::check($this->password, auth()->user()->password)) {
            $this->addError('password', 'كلمة المرور غير صحيحة');
            return;
        }

        $fee = $this->amount * 0.01;
        $net_amount = $this->amount - $fee;
        // dd($this->amount);
        // Create request
        WithdrawRequest::create([
            'user_id' => auth()->id(),
            'amount' => $net_amount, // Submit request for remaining amount
            'network' => $this->network,
            'wallet_address' => $this->wallet_address,
            'status' => 'pending',
            'net_amount' => $this->amount
        ]);

        // Deduct balance
        // auth()->user()->withdraw($this->amount);
        // Manual update
        $user = auth()->user();
        if ($user->balance < $this->amount) {
            $this->addError('amount', 'الرصيد غير كافي');
            return;
        }


        // session()->flash('message', 'تم تقديم طلب السحب بنجاح');
        notify('تم تقديم طلب السحب بنجاح', 'success');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.withdraw-page');
    }
}
