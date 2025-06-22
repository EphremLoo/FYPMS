<?php

namespace App\Livewire\student\Projects;

use App\Models\MeetingLog;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

class CreateMeetingLog extends Component
{
    use Toast;

    public Project $project;

    #[Rule('required')]
    public string $date_time = '';

    #[Rule('required')]
    public string $work_done = '';

    #[Rule('required')]
    public string $work_to_do = '';

    #[Rule('sometimes')]
    public ?string $problems_encountered = null;

    #[Rule('sometimes')]
    public ?string $comments = null;

    public function save(): void
    {
        $data = $this->validate();
        $data['project_id'] = $this->project->id;
        $data['created_by'] = auth()->id();
        $data['meeting_no'] = $this->project->meetingLogs()->count() + 1;

        MeetingLog::create($data);
        
        $this->success('Meeting log created successfully.', redirectTo: route('student.projects.show', $this->project->id));
    }

    public function render()
    {
        return view('livewire.student.projects.create-meeting-log');
    }
}
