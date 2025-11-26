<?php

namespace App\Livewire\Wallets\Transactions;

use Livewire\Component;
use Livewire\WithPagination;

class TransactionsIndex extends Component
{

    use WithPagination;
    public function getData()
    {
        return  auth()->user()->transactions()->latest()->paginate(10);
    }
    public function render()
    {
        $data = $this->getData();
        return view('livewire.wallets.transactions.transactions-index', compact('data'));
    }
}
