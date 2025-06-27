<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\Project;
use App\Models\StudentProjectRequest;
use App\Models\Comments;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;


class ShowProject extends Component
{
    use Toast, withPagination;

    public Project $project;

    #[Rule('required')]
    public string $text = '';

    public int $supervisor_marks = 0;

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
        StudentProjectRequest::where('student_id', $studentProjectRequest->student_id)
            ->where('id', '<>', $studentProjectRequest->id)
            ->update(['status' => StudentProjectRequest::STATUS_WITHDRAWN]);

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

    public function saveProjectMarks(): void
    {
        $data = $this->validate([
            'supervisor_marks' => 'required|numeric',
        ]);
        $this->project->update(['supervisor_marks' => $data['supervisor_marks']]);
        $this->project->updateTotalMarks(); // Update total marks after saving supervisor marks

        $this->success('Project marks updated successfully.');;
    }

    public function delete($commentId): void
    {
        $comment = Comments::findOrFail($commentId);
        if ($comment->created_by != auth()->id()) {
            $this->error('You can only delete your own comments.');
            return;
        }

        $comment->delete();
        $this->success('Comment deleted successfully.');
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
            'comments' => Comments::where('project_id', $this->project->id)
                ->with('createdBy')
                ->latest()
                ->paginate(10),
        ]);
    }
}
