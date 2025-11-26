<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{

    public $selectedRoles = [];

    public $password, $password_confirmation, $phone, $name, $email;
    public $UserStatus = true; // الحالة الافتراضية للمستخدم (نشط)

    public function mount()
    {
        $this->authorize('create', User::class);
    }


    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'nullable|string|max:20',
        'UserStatus' => 'boolean',
        'selectedRoles' => 'array',
        'selectedRoles.*' => 'string|exists:roles,name',
    ];

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password), // 🔒 تشفير كلمة المرور
            'phone' => $this->phone,
            'status' => $this->UserStatus ? 'active' : 'inactive',
        ]);

        if (!empty($this->selectedRoles)) {
            $user->assignRole($this->selectedRoles);
        }

        notify(__('Permission Created Successfully'), 'success');

        // إعادة تعيين الحقول
        return redirect()->route('users.index');
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.users.user-create', compact('roles'));
    }
}
