<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\On;

class PermissionsIndex extends Component
{
    use WithPagination;


    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';


    public function getData()
    {

        $query = Permission::query();

        if ($this->search) {
            $this->resetPage();
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }

    // #[On('delete-confirmted')]
    public function delete(string $id)
    {

        confermeDelete(
            $this,
            __('Are you sure'),
            __('you want to delete this permission?'),
            $id
        );
    }

    #[On('delete-confirmted')]
    public function deleteConfirmted(string $id)
    {


        $permissions = permission::find($id);
        $permissions->delete();

        notify($permissions->name . '  ' . __('Permission Deleted Successfully'), 'success', false);
    }

    public function render()
    {

        // Authorization check for viewing any permissions
        $this->authorize('viewAny', Permission::class);


        $permissions = $this->getData();
        return view('livewire.permissions.permissions-index', compact('permissions'));
        //

    }
}
