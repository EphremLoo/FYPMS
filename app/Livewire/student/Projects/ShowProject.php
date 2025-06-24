<?php

namespace App\Livewire\student\Projects;

use App\Models\Project;
use App\Models\StudentProjectRequest;
use App\Models\Comments;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class ShowProject extends Component
{
    use Toast, WithPagination, WithFileUploads;

    public Project $project;

    #[Rule('required')]
    public string $text = '';

    public $file;

    public string $selectedTab = 'project-details-tab';

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    public function mount(): void
    {
        $this->fill($this->project);
    }

    public function apply(): void
    {
        if (StudentProjectRequest::where('project_id', $this->project->id)->where('student_id', auth()->id())->where('status', StudentProjectRequest::STATUS_PENDING)->exists()) {
            $this->error('Project applied already.');
            return;
        }

        if ($this->project->created_by == auth()->id() || $this->project->student_id == auth()->id()) {
            $this->error('Cannot apply to your own project.');
            return;
        }

        if (!empty($this->project->student_id)) {
            $this->error('Cannot apply to a project that has been taken by a student.');
            return;
        }

        StudentProjectRequest::create([
            'project_id' => $this->project->id,
            'student_id' => auth()->id(),
        ]);
        $this->project->update(['total_applications' => $this->project->total_applications + 1]);

        $this->success('Project applied successfully. Please wait for the supervisor to approve your application.');
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['project_id'] = $this->project->id;
        $data['created_by'] = auth()->id();

        Comments::create($data);

        $this->text = ''; // Clear the text input after saving
    }

    public function uploadFile(): void
    {
        $path = $this->file->store(path: 'projects/' . $this->project->id, options: 'public');
        $this->project->update(['file' => Storage::url($path)]);

        $this->success('Project submitted successfully.');
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
        return view('livewire.student.projects.show', [
            'logs' => $this->project->meetingLogs()
                ->orderBy(...array_values($this->sortBy))
                ->paginate(10),
            'logHeaders' => [
                ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
                ['key' => 'meeting_no', 'label' => 'Meeting No', 'class' => 'w-1'],
                ['key' => 'date_time', 'label' => 'Date', 'format' => ['date', 'd/m/Y'], 'sortable' => false],
            ],
            'comments' => Comments::where('project_id', $this->project->id) // $this->project->meetingLogs(), same thing
                ->with('createdBy')
                ->latest()
                ->paginate(10),
        ]);
    }
}
