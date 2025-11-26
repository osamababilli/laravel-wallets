<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;


class Index extends Component
{
    use WithPagination;


    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';


    public function getData()
    {

        $query = Role::query();

        if ($this->search) {
            $this->resetPage();
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }

    public function delete(string $id)
    {

        confermeDelete(
            $this,
            __('Are you sure'),
            __('Are you sure you want to delete this role?'),
            $id
        );
    }

    #[On('delete-confirmted')]
    public function deleteConfirmted(string $id)
    {


        $role = Role::find($id);
        $role->delete();
        // $this->dispatch('deleted',  message: $role->name . '  ' . __('Role Deleted Successfully'), type: 'success');

        notify($role->name . '  ' . __('Role Deleted Successfully'), 'success', false);
    }






    public function render()
    {
        $roles = $this->getData();
        return view('livewire.roles.index', compact('roles'));
    }
}
