<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Workbench\App\Models\User;

class UserShow extends Component
{


    public function mount()
    {
        $this->authorize('show', User::class);
    }
    public function render()
    {
        return view('livewire.users.user-show');
    }
}
