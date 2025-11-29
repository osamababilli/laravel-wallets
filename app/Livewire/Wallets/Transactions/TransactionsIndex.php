<?php

namespace App\Livewire\Wallets\Transactions;

use Livewire\Component;
use Livewire\WithPagination;
use Bavix\Wallet\Models\Transaction;

class TransactionsIndex extends Component
{

    use WithPagination;
    public function getData()
    {
        if (auth()->user()->hasRole('super admin')) {
            return Transaction::orderBy('created_at', 'desc')->paginate(20);
        } else {
            return auth()->user()->transactions()->orderBy('created_at', 'desc')->paginate(20);
        }
    }
    public function render()
    {
        $data = $this->getData();
        return view('livewire.wallets.transactions.transactions-index', compact('data'));
    }
}
