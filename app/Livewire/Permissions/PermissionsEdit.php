<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Models\Activity;

class PermissionsEdit extends Component
{

    public  $permission, $PermissionName, $guardName, $permissionData;

    public function mount($permission)
    {





        $this->permission = $permission;
        $this->permissionData = Permission::find($permission);
        $this->PermissionName = $this->permissionData->name;
        $this->guardName = $this->permissionData->guard_name;


        // Authorization check for editing a permission
        $this->authorize('update', Permission::class);
    }


    public function updatePermission()
    {

        $this->validate([
            'PermissionName' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $this->permission],
            'guardName' => ['required', 'string', 'max:255'],
        ]);


        // dd($this->PermissionName);
        // this is to remove any leading or trailing spaces from the permission name before saving
        $normailizedPermissionName = trim($this->PermissionName);

        // dd($normailizedPermissionName);
        // تحديث البيانات
        $this->permissionData->update([
            'name' => $normailizedPermissionName,
            'guard_name' => $this->guardName,

        ]);





        //إذا تريد الإشعار يظهر بعد redirect
        notify(__('Permission Updated Successfully'), 'success', false);
    }

    public function render()
    {
        return view('livewire.permissions.permissions-edit');
    }
}
