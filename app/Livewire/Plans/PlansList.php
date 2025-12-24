<?php

namespace App\Livewire\Plans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Plan;
use Flux\Flux;
use Livewire\Attributes\On;

class PlansList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';



    public $requiredAmount, $profit, $type, $name, $status, $plan;


    public function getdata()
    {
        $query = Plan::query()->with(['members']);

        if ($this->search) {
            $this->resetPage();
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }


    public function EditPlan($id)
    {

        $this->plan = Plan::find($id);
        $this->name = $this->plan->name;
        $this->requiredAmount = $this->plan->amount;
        $this->profit = $this->plan->profit;
        $this->type = $this->plan->type;
        $this->status = $this->plan->status;


        Flux::modal('editPlan')->show();
    }


    public function editPlanFn()
    {




        // dd($this->plan);
        $this->validate([
            'name' => 'required',
            'requiredAmount' => 'required',
            'profit' => 'required',
            'type' => 'required|in:daily,weekly,monthly,yearly',
            'status' => 'required'
        ]);
        Flux::modal('editPlan')->close();
        $this->plan->update([
            'name' => $this->name,
            'amount' => $this->requiredAmount,
            'profit' => $this->profit,
            'type' => $this->type,
            'status' => $this->status


        ]);

        $this->name = '';
        $this->requiredAmount = '';
        $this->profit = '';
        $this->type = '';

        notify(__('Plan Created Successfully'), 'success', false);
    }

    public function CreatePlanFn()
    {

        $this->validate([
            'name' => 'required',
            'requiredAmount' => 'required',
            'profit' => 'required',
            'type' => 'required|in:daily,weekly,monthly,yearly'
        ]);
        Flux::modal('NewPlan')->close();
        Plan::create([
            'name' => $this->name,
            'amount' => $this->requiredAmount,
            'profit' => $this->profit,
            'type' => $this->type
        ]);

        $this->name = '';
        $this->requiredAmount = '';
        $this->profit = '';
        $this->type = '';

        notify(__('Plan Created Successfully'), 'success', false);
    }


    public function delete(string $id)
    {

        confermeDelete(
            $this,
            __('Are you sure'),
            __('Are you sure you want to delete this User?'),
            $id
        );
    }

    #[On('delete-confirmted')]
    public function deleteConfirmted(string $id)
    {


        $User = Plan::find($id);
        $User->delete();

        notify($User->name . '  ' . __('Plan Deleted Successfully'), 'success', false);
    }


    public function render()
    {

        $plans = $this->getdata();
        return view('livewire.plans.plans-list', compact('plans'));
    }
}
