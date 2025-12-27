<?php

namespace App\Livewire;

use App\Models\CryptoWalle;
use Livewire\Component;

class DepositPage extends Component
{


    public function mount()
    {
        if (session()->has('wallet_error')) {
            notify(__('لا يوجد كافية رصيد للاستفادة من هذه الخدمة'), 'warning', false);
        }
    }

    public function render()
    {
        $wallets = CryptoWalle::where('status', 'active')->get();

        return view('livewire.deposit-page', [
            'wallets' => $wallets,
        ]);
    }
}
