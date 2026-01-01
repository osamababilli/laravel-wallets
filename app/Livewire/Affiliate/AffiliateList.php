<?php

namespace App\Livewire\Affiliate;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AffiliateProfit;

class AffiliateList extends Component
{
    use WithPagination;

    public function getData()
    {
        if (auth()->user()->hasRole('super admin')) {
            return AffiliateProfit::with('user')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            return auth()->user()->inviterProfit()->orderBy('created_at', 'desc')->paginate(20);
        }
    }

    public function render()
    {
        $profits = $this->getData();
        return view('livewire.affiliate.affiliate-list', compact('profits'));
    }
}
