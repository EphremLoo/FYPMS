<?php

namespace App\Livewire\moderator\Projects;

use App\Models\MeetingLog;
use App\Models\Project;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowMeetingLog extends Component
{
    // use Toast;

    public Project $project;

    public MeetingLog $meeting_log;

    public function render()
    {
        return view('livewire.moderator.projects.show-meeting-log');
    }
}
