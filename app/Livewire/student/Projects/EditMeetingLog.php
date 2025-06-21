<?php

namespace App\Livewire\student\Projects;

use App\Models\MeetingLog;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

class EditMeetingLog extends Component
{
    use Toast;

    public Project $project;
    public MeetingLog $meeting_log;

    #[Rule('required')]
    public string $work_done = '';

    #[Rule('required')]
    public string $work_to_do = '';

    #[Rule('sometimes')]
    public ?string $problems_encountered = null;

    #[Rule('sometimes')]
    public ?string $comments = null;

    public function mount(MeetingLog $meeting_log): void
    {
        $this->work_done = $meeting_log->work_done ?? '';
        $this->work_to_do = $meeting_log->work_to_do ?? '';
        $this->problems_encountered = $meeting_log->problems_encountered ?? '';
        $this->comments = $meeting_log->comments ?? '';
    }   

    public function save(): void 
    {
        $data = $this->validate();
        $data['project_id'] = $this->project->id;
        $data['updated_by'] = auth()->id();
        
        // Update the meeting log
        $this->meeting_log->update($data);
        
        // Toast success message and redirect
        $this->success('Meeting log updated successfully.', redirectTo: route('student.projects.meetingloglist', $this->project->id));
    }

    // Delete action
    public function delete(MeetingLog $meeting_log): void
    {
        $meeting_log->delete();
        $this->warning("Deleting #$meeting_log->meeting_no", position: 'toast-bottom', redirectTo: route('student.projects.meetingloglist', $this->project->id));
    }

    public function render()
    {
        return view('livewire.student.projects.edit-meeting-log');
    }
}