<?php

namespace App\Livewire;

use App\Models\CryptoWalle;
use App\Models\WalletRequest;
use flux\Flux;
use Livewire\Component;

class DepositDetails extends Component
{
    public CryptoWalle $wallet;
    public $amount;

    public function mount(CryptoWalle $wallet)
    {
        $this->wallet = $wallet;
    }

    public function save()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        WalletRequest::create([
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'type' => 'deposit',
            'status' => 'pending',
            // Assuming default status is pending, but explicit is better if column doesn't have default.
            // Also need to link to the specific wallet if WalletRequest has a relation? 
            // The model shown doesn't have wallet_id. Assuming just a request for now.
        ]);

        // Show success notification or redirect
        // Flux::toast('Deposit request submitted successfully.'); 
        // Or using standard session flash
        session()->flash('message', 'Deposit request submitted successfully.');

        notify('تم ارسال طلبك بنجاح', 'success', true);

        return redirect()->route('deposit-page.index');
    }

    public function render()
    {
        return view('livewire.deposit-details');
    }
}
