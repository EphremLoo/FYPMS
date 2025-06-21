<?php

namespace App\Livewire\student\Projects;

use App\Models\Project;
use Livewire\Component;
use Mary\Traits\Toast;

class MeetingLogList extends Component
{
    use Toast;

    public Project $project;

    public $title = 'Meeting Logs';

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    public function render()
    {
        return view('livewire.student.projects.meeting-log-list', [
            'logs' => $this->project->meetingLogs()
                ->orderBy(...array_values($this->sortBy))
                ->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
                ['key' => 'meeting_no', 'label' => 'Meeting No', 'class' => 'w-1'],
                ['key' => 'date_time', 'label' => 'Date', 'format' => ['date', 'd/m/Y'], 'sortable' => false],
            ],
        ]);
    }
}
