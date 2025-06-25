<?php

namespace App\Livewire\student\Projects;

use App\Models\Project;
use App\Models\StudentProjectRequest;
use App\Models\Comments;
use App\Models\SupervisorProjectRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class ShowProject extends Component
{
    use Toast, WithPagination, WithFileUploads;

    public Project $project;

    #[Rule('required')]
    public string $text = '';

    #[Rule('required')]
    public ?string $supervisor_id = null;

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

    public function requestSupervisor(): void
    {
        // check if a project already has a supervisor assigned
        if ($this->project->supervisor_id) {
            $this->error('Project already has a supervisor assigned.');
            return;
        }

        // check if user has already made a request for this project but with pending status
        $request_exists = SupervisorProjectRequest::where('project_id', $this->project->id)
        ->where('student_id', auth()->id())
        ->where('supervisor_id', $this->supervisor_id)
        ->where('status', SupervisorProjectRequest::STATUS_PENDING)
        ->exists();
        if ($request_exists) {
            $this->error('You have already requested supervisor for this project. Please wait for the supervisor to accept your request.');
            return;
        }

        // create a new request
        SupervisorProjectRequest::create([
            'project_id' => $this->project->id,
            'student_id' => auth()->id(),
            'supervisor_id' => $this->supervisor_id,
            'status' => SupervisorProjectRequest::STATUS_PENDING,
        ]);

        $this->success('Supervisor request sent successfully. Please wait for the supervisor to accept your request.');
    }

    public function uploadFile(): void
    {
        $path = $this->file->storeAs(path: 'projects/' . $this->project->id, name: $this->project->name . '-fyp-submission.' . $this->file->getClientOriginalExtension(), options: 'public');
        if (!empty($this->project->file)) {
            File::delete($this->project->file);
        }
        $this->project->update(['file' => Storage::url($path)]);
        $this->project->update(['status' => Project::STATUS_COMPLETED]);

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
            'supervisors' => User::role(User::ROLE_SUPERVISOR)->get(),
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
