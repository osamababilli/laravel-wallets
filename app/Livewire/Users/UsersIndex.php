<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Flux\Flux;

class UsersIndex extends Component
{
    use WithPagination;



    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';


    public $userId = null, $amount;




    public function mount()
    {
        $this->authorize('viewAny', User::class);
    }
    public function getData()
    {

        $query = User::query()->with(['roles', 'wallets']);

        if ($this->search) {
            $this->resetPage();
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('user_number', 'like', '%' . $this->search . '%');
            });
        }
        return $query->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }


    public function delete(string $id)
    {
        $this->authorize('delete', User::class);


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


        $User = User::find($id);
        $User->delete();

        notify($User->name . '  ' . __('Role Deleted Successfully'), 'success', false);
    }

    public function editUserBalance($userId)
    {
        $this->userId = $userId;
        Flux::modal('DepositModal')->show();
    }


    public function deposit()
    {
        $user = User::find($this->userId);
        $user->wallets()->first()->deposit($this->amount);
        // dd($this->userId, $this->amount);
        notify(__('Amount Deposited Successfully'), 'success', false);
        $this->reset(['amount', 'userId']);
        Flux::modal('DepositModal')->close();
    }



    public function render()
    {
        $users = $this->getData();
        return view('livewire.users.users-index', compact('users'));
    }
}
