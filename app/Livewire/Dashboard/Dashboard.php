<?php

namespace App\Livewire\Dashboard;

use App\Models\CryptoWalle;
use App\Models\WalletRequest;
use Flux\Flux;
use Illuminate\Container\Attributes\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\ProfitWithdrawal;

class Dashboard extends Component
{

    public $depositAmount, $selectedWallet, $profit, $peddingprofit;
    public $adminProfits;



    public function GetAdminProfit()
    {
        $amount = ProfitWithdrawal::where("status", "approved")->sum('amount');
        $net_amount = ProfitWithdrawal::where("status", "approved")->sum('net_amount');
        return $amount - $net_amount;

    }




    public function GetUserCurrentProfit()
    {
        $members = \App\Models\Member::where('user_id', auth()->id())->get();
        $total = 0;
        foreach ($members as $member) {
            $total += $member->getCurrentProfit();
        }
        return $total;
    }




    public function mount()
    {

        $this->profit = ProfitWithdrawal::where("user_id", auth()->user()->id)->where("status", "approved")->sum('amount');
        $this->peddingprofit = $this->GetUserCurrentProfit();
        $this->adminProfits = $this->GetAdminProfit();

        if (session()->has('wallet_error')) {

            $data = session('wallet_error');

            $this->dispatch(
                'insufficientBalance',
                amount: $data['amount']
            );
        }
    }
    public function deposit()
    {


        // dd();


        $this->validate([
            'depositAmount' => ['required', 'numeric', 'min:10'],
        ]);


        WalletRequest::create([
            'amount' => $this->depositAmount,
            'type' => 'deposit',
            'status' => 'pending',
            'user_id' => auth()->user()->id,
        ]);

        $this->depositAmount = '';

        Flux::modal('DepositModal')->close();
        // Logic to handle deposit action
        notify('Deposit request submitted successfully', 'success', false);
    }


    #[On('insufficientBalance')]
    public function insufficientBalance($amount)
    {


        $this->depositAmount = $amount;
        Flux::modal('DepositModal')->show();
    }

    public function goToDeposit()
    {
        return redirect()->route('deposit-page.index');
    }

    public function goToWithdraw()
    {
        return redirect()->route('withdraw-page.index');

    }



    public function Withdraw()
    {

        $this->validate([
            'depositAmount' => ['required', 'numeric', 'min:10'],
        ]);


        WalletRequest::create([
            'amount' => $this->depositAmount,
            'type' => 'withdraw',
            'status' => 'pending',
            'user_id' => auth()->user()->id,
        ]);

        $this->depositAmount = '';

        Flux::modal('WithdrawModal')->close();
        // Logic to handle deposit action
        notify('Withdraw request submitted successfully', 'success', false);
    }


    public function FastDeposit($amount)
    {
        $this->depositAmount = $amount;

        Flux::modal('DepositModal')->show();
    }
    public function render()
    {

        $invite_code = auth()->user()->invite_code;
        $cryptos = CryptoWalle::where('status', 'active')->get();
        $data = auth()->user()->transactions()->orderBy('created_at', 'desc')->take(5)->get();
        return view('livewire.dashboard.dashboard', compact('data', 'cryptos', 'invite_code'));
    }
}
