<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{




    public $user;
    public $selectedRoles = [];
    public $password, $password_confirmation, $phone, $name, $email;
    public $UserStatus;
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . '{user_id}', // استثناء البريد الإلكتروني للمستخدم الحالي
        'password' => 'nullable|string|min:8|confirmed',
        'phone' => 'nullable|string|max:20',
        'UserStatus' => 'boolean',
        'selectedRoles' => 'array',
        'selectedRoles.*' => 'string|exists:roles,name',
    ];


    public function mount($user)
    {
        // التحقق من الصلاحية
        $this->authorize('update', User::class);
        // جلب بيانات المستخدم بناءً على المعرف وتمريرها إلى الخصائص
        $userData = User::find($user);
        $this->user = $userData;
        $this->name = $userData->name;
        $this->email = $userData->email;
        $this->phone = $userData->phone;
        $this->UserStatus = $userData->status;
        $this->selectedRoles = $userData->roles->pluck('name')->toArray();
    }

    public function updateUser()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,' . $this->user->id, // استثناء البريد الإلكتروني للمستخدم الحالي
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->phone = $this->phone;
        $this->user->status = $this->UserStatus;

        if (!empty($this->password)) {
            $this->validate([
                'password' => 'nullable|string|min:8|confirmed',
            ]);
            $this->user->password = bcrypt($this->password);
        }

        $this->user->save();

        // تحديث الأدوار
        $this->user->syncRoles($this->selectedRoles);

        notify(__('User updated successfully!'), 'success');

        return redirect()->route('users.index');
    }
    public function render()
    {

        $roles = Role::all();
        return view('livewire.users.user-edit', compact('roles'));
    }
}
