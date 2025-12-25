<?php

namespace App\Livewire\Plans\UsersPlans;

use App\Models\Member;
use Livewire\Component;

class MyInvestments extends Component
{



    public function GetData()
    {

        return Member::where('user_id', auth()->user()->id)->get();
    }
    public function render()
    {
        $inverstments = $this->GetData();
        return view('livewire.plans.users-plans.my-investments', compact('inverstments'));
    }
}
