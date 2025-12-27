<?php

namespace App\Livewire\Plans\UsersPlans;

use App\Livewire\Dashboard\Dashboard;
use App\Models\Plan;
use Livewire\Component;

class PlansList extends Component
{


    public function subscribe($id)
    {

        $plan = Plan::find($id);

        if (!$plan) {
            notify(__('Plan Not Found'), 'warning', false);
            return;
        }

        if ($plan->members()->where('user_id', auth()->user()->id)->exists()) {
            notify(__('You are already subscribed to this plan'), 'warning', false);
            return;
        }


        if ($plan->amount > auth()->user()->balance) {

            session()->flash('wallet_error', [
                'amount'  => $plan->amount
            ]);

            return redirect()->route('dashboard');
        }



        $plan->members()->create([
            'user_id' => auth()->user()->id

        ]);

        auth()->user()->withdraw($plan->amount);



        notify(__('Subscribed Successfully'), 'success', false);
    }


    public function GetData()
    {
        return Plan::where('status', 'active')->get();
    }
    public function render()
    {
        $plans = $this->GetData();
        return view('livewire.plans.users-plans.plans-list', compact('plans'));
    }
}
