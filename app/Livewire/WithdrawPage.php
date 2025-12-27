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

        // Create request
        WithdrawRequest::create([
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'network' => $this->network,
            'wallet_address' => $this->wallet_address,
            'status' => 'pending',
        ]);

        // Deduct balance
        // auth()->user()->withdraw($this->amount); // Assuming bavix/laravel-wallet or similar trait method exists, or manual update
        // Manual update for now if trait not confirmed to allow negative check overlap, 
        // but typically:
        // $user = auth()->user();
        // $user->withdraw($this->amount);
        // $user->save();

        // session()->flash('message', 'تم تقديم طلب السحب بنجاح');
        notify('تم تقديم طلب السحب بنجاح', 'success');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.withdraw-page');
    }
}
