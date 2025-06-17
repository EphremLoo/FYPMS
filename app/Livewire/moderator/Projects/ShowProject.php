<?php

namespace App\Livewire\moderator\Projects;

use App\Models\Project;
use App\Models\StudentProjectRequest;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowProject extends Component
{
    use Toast;

    public Project $project;

    public function mount(): void
    {
        $this->fill($this->project);
    }

    public function approve(StudentProjectRequest $studentProjectRequest): void
    {
        $studentProjectRequest->update(['status' => StudentProjectRequest::STATUS_APPROVED]);
        $this->project->update(['student_id' => $studentProjectRequest->student_id]);
        StudentProjectRequest::where('student_id', $studentProjectRequest->student_id)->where('id', '<>', $studentProjectRequest->id)->update(['status' => StudentProjectRequest::STATUS_WITHDRAWN]);

        $this->success('Request approved successfully.');
    }

    public function reject(StudentProjectRequest $studentProjectRequest): void
    {
        $studentProjectRequest->update(['status' => StudentProjectRequest::STATUS_REJECTED]);

        $this->success('Request rejected successfully.');
    }

    public function render()
    {
        return view('livewire.moderator.projects.show', [
            'headers' => [
                ['key' => 'student_id', 'label' => 'Student Name',],
                ['key' => 'status_text', 'label' => 'Status',],
            ],
        ]);
    }
}
