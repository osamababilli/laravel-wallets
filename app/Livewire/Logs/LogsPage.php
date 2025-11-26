<?php

namespace App\Livewire\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class LogsPage extends Component

{
    use WithPagination;
    public function render()
    {
        $this->authorize('viewAny', Activity::class);

        $logs = \Spatie\Activitylog\Models\Activity::latest()->paginate(10);
        $allLogs = \Spatie\Activitylog\Models\Activity::all();
        return view('livewire.logs.logs-page', compact('logs', 'allLogs'));
    }
}
