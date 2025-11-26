<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;


class Create extends Component
{

    public $roleName = '';
    public $guardName = '';
    public $selectedPermissions = [];
    public $selectAll = false;

    public function createRole()
    {

        $this->validate([
            'roleName' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'guardName' => ['required', 'string', 'max:255'],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['string', 'exists:permissions,name'],
        ]);

        // dd($this->selectedPermissions);

        $role = Role::create([
            'name' => $this->roleName,
            'guard_name' => $this->guardName

        ]);
        $role->syncPermissions($this->selectedPermissions);

        // $this->dispatch('created',  message: $role->name . '  ' . __('Role Created Successfully'), type: 'success');
        LivewireAlert::title($role->name . '  ' . __('Role Created Successfully'))
            ->success()
            ->show();

        $this->reset();
    }


    public function toggleSelectAllPermissions()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selectedPermissions = $this->getPermissions()->pluck('name')->toArray();
        } else {
            $this->selectedPermissions = [];
        }
    }

    public function getPermissions()
    {

        return Permission::where('guard_name', $this->guardName)->get();
    }
    public function render()
    {
        $pemissions = $this->getPermissions();
        return view('livewire.roles.create', compact('pemissions'));
    }
}
