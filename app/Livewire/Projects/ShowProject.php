<?php

namespace App\Livewire\Projects;

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
        if (StudentProjectRequest::where('project_id', $this->project->id)->where('student_id', auth()->id())->exists()) {
            $this->error('Project applied already.');
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
        return view('livewire.projects.show');
    }
}
