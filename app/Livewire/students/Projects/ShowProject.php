<?php

namespace App\Livewire\students\Projects;

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

    public function apply(): void
    {
        if (StudentProjectRequest::where('project_id', $this->project->id)->where('student_id', auth()->id())->where('status', StudentProjectRequest::STATUS_PENDING)->exists()) {
            $this->error('Project applied already.');
            return;
        }

        if ($this->project->created_by === auth()->id() || $this->project->student_id === auth()->id()) {
            $this->error('Cannot apply to your own project.');
            return;
        }

        StudentProjectRequest::create([
            'project_id' => $this->project->id,
            'student_id' => auth()->id(),
        ]);

        $this->success('Project applied successfully. Please wait for the supervisor to approve your application.');
    }

    public function render()
    {
        return view('livewire.student.projects.show');
    }
}
