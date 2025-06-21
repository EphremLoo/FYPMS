<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\Project;
use App\Models\StudentProjectRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ShowProject extends Component
{
    use Toast, withPagination;

    public Project $project;

    public string $selectedTab = 'project-details-tab';

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

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
        return view('livewire.supervisor.projects.show', [
            'studentProjectRequest' => StudentProjectRequest::where('project_id', $this->project->id)->latest()->paginate(10),
            'studentHeaders' => [
                ['key' => 'id', 'label' => 'ID',],
                ['key' => 'student_id', 'label' => 'Student Name',],
                ['key' => 'status_text', 'label' => 'Status',],
            ],
            'logs' => $this->project->meetingLogs()
                ->orderBy(...array_values($this->sortBy))
                ->paginate(10),
            'logHeaders' => [
                ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
                ['key' => 'meeting_no', 'label' => 'Meeting No', 'class' => 'w-1'],
                ['key' => 'date_time', 'label' => 'Date', 'format' => ['date', 'd/m/Y'], 'sortable' => false],
            ],
        ]);
    }
}
