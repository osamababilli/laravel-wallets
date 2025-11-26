<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class UsersIndex extends Component
{
    use WithPagination;



    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';



    public function mount()
    {
        $this->authorize('viewAny', User::class);
    }
    public function getData()
    {

        $query = User::query();

        if ($this->search) {
            $this->resetPage();
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
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

    public function render()
    {
        $users = $this->getData();
        return view('livewire.users.users-index', compact('users'));
    }
}
