<?php

namespace App\Livewire\moderator\Projects;

use App\Models\Comments;
use App\Models\Project;
use App\Models\StudentProjectRequest;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowProject extends Component
{
    use Toast;

    public Project $project;

    public string $selectedTab = 'project-details-tab';

    #[Rule('required')]
    public string $text = '';

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

    public function save(): void
    {
        $data = $this->validate();
        $data['project_id'] = $this->project->id;
        $data['created_by'] = auth()->id();

        Comments::create($data);

        $this->text = ''; // Clear the text input after saving
    }

    public function render()
    {
        return view('livewire.moderator.projects.show', [
            'headers' => [
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
            'comments' => Comments::where('project_id', $this->project->id)
                ->with('createdBy')
                ->latest()
                ->paginate(10),
        ]);
    }
}
