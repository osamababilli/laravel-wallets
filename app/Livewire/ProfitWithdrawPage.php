<?php

namespace App\Livewire;

use App\Models\ProfitWithdrawal;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Url;

class ProfitWithdrawPage extends Component
{
    #[Url]
    public $amount;

    #[Url]
    public $member_id;

    public $network;
    public $wallet_address;
    public $password;

    public $networks = ['TRX', 'BNB', 'POLYGON', 'ETH'];

    public function mount()
    {
        if (!$this->amount || !$this->member_id) {
            abort(404, 'Missing required parameters');
        }
    }

    protected function messages()
    {
        return [
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
            'network' => 'required',
            'wallet_address' => 'required|string|min:10',
            'password' => 'required',
        ]);

        if (!Hash::check($this->password, auth()->user()->password)) {
            $this->addError('password', 'كلمة المرور غير صحيحة');
            return;
        }

        // Create ProfitWithdrawal (Approved)
        ProfitWithdrawal::create([
            'user_id' => auth()->id(),
            'member_id' => $this->member_id,
            'amount' => $this->amount,
            'network' => $this->network,
            'wallet_address' => $this->wallet_address,
            'status' => 'approved',
        ]);

        // Create WithdrawRequest (Pending)
        WithdrawRequest::create([
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'network' => $this->network,
            'wallet_address' => $this->wallet_address,
            'status' => 'pending',
        ]);

        notify('تم تقديم طلب سحب الأرباح بنجاح', 'success');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.profit-withdraw-page');
    }
}
