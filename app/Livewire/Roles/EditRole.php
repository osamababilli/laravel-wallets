<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class EditRole extends Component
{


    public $role, $roleName, $guardName, $roleData;
    public $selectedPermissions = [];
    public $selectAll = false;

    public function mount($role)
    {
        $this->role = $role;
        $roleData = Role::find($role);
        $this->roleData = $roleData;
        $this->roleName = $roleData->name;
        $this->guardName = $roleData->guard_name;
        $this->selectedPermissions = $roleData->permissions->pluck('name')->toArray();
    }

    public function updateRole()
    {

        $this->validate([
            'roleName' => ['required', 'string', 'max:255', 'unique:roles,name,' . $this->roleData->id],
            'guardName' => ['required', 'string', 'max:255'],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['string', 'nullable', 'exists:permissions,name'],
        ]);
        // $this->selectedPermissions = array_map('trim', $this->selectedPermissions);

        //dd($this->selectedPermissions);



        // تحديث البيانات
        $this->roleData->update([
            'name' => $this->roleName,
            'guard_name' => $this->guardName,

        ]);

        $this->roleData->syncPermissions($this->selectedPermissions);




        notify(__('Role Created Successfully'), 'success');

        // redirect بعد الإشعار
        return redirect()->route('roles.index');
    }
    public function getPermissions()
    {

        return Permission::where('guard_name', $this->guardName)->get();
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


    public function render()
    {
        $pemissions = $this->getPermissions();
        return view('livewire.roles.edit-role', compact('pemissions'));
    }
}
