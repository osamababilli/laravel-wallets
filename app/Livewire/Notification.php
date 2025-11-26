<?php

namespace App\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;


class Notification extends Component
{

    public function mount()
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->success()
                ->show();
        }
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
