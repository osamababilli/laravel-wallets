<?php

namespace App\Livewire\Dashboard;

use App\Models\CryptoWalle;
use App\Models\WalletRequest;
use Flux\Flux;
use Illuminate\Container\Attributes\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public $depositAmount, $selectedWallet;


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
    public function render()
    {


        $cryptos = CryptoWalle::where('status', 'active')->get();
        $data = auth()->user()->transactions()->orderBy('created_at', 'desc')->take(5)->get();
        return view('livewire.dashboard.dashboard', compact('data', 'cryptos'));
    }
}
