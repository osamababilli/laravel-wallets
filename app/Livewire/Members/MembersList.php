<?php

namespace App\Livewire\Members;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;

class MembersList extends Component
{

    use WithPagination;


    public function GetData()
    {
        return Member::latest()->paginate(30);
    }
    public function render()
    {
        $members = $this->GetData();
        return view('livewire.members.members-list', compact('members'));
    }
}
