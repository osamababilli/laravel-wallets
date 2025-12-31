<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\ProfitWithdrawal;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Url;

class ProfitWithdrawPage extends Component
{
    #[Url]
    public $amount; // Kept for URL compatibility, but treated as display-only hint

    #[Url]
    public $member_id;

    public $network;
    public $wallet_address;
    public $password;

    public $networks = ['TRX', 'BNB', 'POLYGON', 'ETH'];

    public $calculatedAmount = 0;

    public function mount()
    {
        if (!$this->member_id) {
            abort(404, 'Missing required parameters');
        }

        $member = Member::where('id', $this->member_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check for pending withdrawals
        $hasPending = $member->profitWithdrawals()->where('status', 'pending')->exists();
        if ($hasPending) {
            abort(403, 'لديك طلب سحب قيد المراجعة بالفعل لهذا الاستثمار.');
        }

        // Server-side calculation is the source of truth
        $this->calculatedAmount = $member->getCurrentProfit();

        // Optional: Block if amount is 0
        if ($this->calculatedAmount <= 0) {
            abort(403, 'لا توجد أرباح متاحة للسحب.');
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

        // Re-fetch member to ensure security at the moment of execution
        $member = Member::where('id', $this->member_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Verify pending again
        if ($member->profitWithdrawals()->where('status', 'pending')->exists()) {
            $this->addError('amount', 'يوجد طلب سحب معلق.');
            return;
        }

        // Calculate FRESH amount
        $realAmount = $member->getCurrentProfit();


        $fee = $realAmount * 0.01;


        if ($realAmount <= 0) {
            $this->addError('amount', 'عذراً، الرصيد المتاح للسحب هو 0.');
            return;
        }

        // Create ProfitWithdrawal (Approved) - Using REAL amount
        ProfitWithdrawal::create([
            'user_id' => auth()->id(),
            'member_id' => $this->member_id,
            'amount' => $realAmount,
            'network' => $this->network,
            'wallet_address' => $this->wallet_address,
            'status' => 'approved',
        ]);


        $user = auth()->user();

        $user->deposit($realAmount);

        $user->save();
        // Create WithdrawRequest (Pending) - Using REAL amount
        WithdrawRequest::create([
            'user_id' => auth()->id(),
            'amount' => $realAmount - $fee,
            'network' => $this->network,
            'wallet_address' => $this->wallet_address,
            'status' => 'pending',
            'net_amount' => $realAmount,
        ]);

        notify('تم تقديم طلب سحب الأرباح بنجاح', 'success');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.profit-withdraw-page', [
            // Pass calculated amount to view to override URL param display if needed,
            // though public property $calculatedAmount is accessible
        ]);
    }
}
