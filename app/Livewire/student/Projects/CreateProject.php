<?php

namespace App\Livewire\student\Projects;

use App\Models\Project;
use App\Models\SupervisorProjectRequest;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateProject extends Component
{
    use Toast;

    // You could use Livewire "form object" instead.
    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public string $description = '';

    #[Rule('sometimes')]
    public ?string $student_id = null;

    #[Rule('sometimes')]
    public ?string $supervisor_id = null;

    #[Rule('sometimes')]
    public ?string $moderator_id = null;

    #[Rule('sometimes')]
    public ?string $examiner_id = null;

    public function save(): void
    {
        if (Auth()->user()->hasRole(User::ROLE_STUDENT) && Project::where('created_by', auth()->id())->count() >= 3) {
            $this->error('Students can only create a maximum of 3 projects', redirectTo: route('student.projects.create'));
            return;
        }

        $data = $this->validate();

        if (auth()->user()->hasRole(User::ROLE_STUDENT)) {
            $data['student_id'] = auth()->id();
        }
        if (auth()->user()->hasRole(User::ROLE_SUPERVISOR)) {
            $data['supervisor'] = auth()->id();
        }

        $data['created_by'] = auth()->id();
        $data['year'] = now()->year;

        // assign variable for supervisor_id to be used for SupervisorProjectRequest unset the supervisor_id so that it does not end up in the project 
        $supervisor_id = $data['supervisor_id'] ?? null;
        unset($data['supervisor_id']);

        // create the project
        $project = Project::create($data);

        // Insert data into the SupervisorProjectRequest table
        if ($supervisor_id) {
            SupervisorProjectRequest::create([
            'project_id'   => $project->id,
            'student_id'   => auth()->id(),
            'supervisor_id'=> $supervisor_id,
            'status'       => \App\Models\SupervisorProjectRequest::STATUS_PENDING,
        ]);
    }

        $this->success('Project created with success.', redirectTo: route('student.projects.index'));
    }

    public function render()
    {
        return view('livewire.student.projects.create', [
            'students' => User::role(User::ROLE_STUDENT)->get(),
            'supervisors' => User::role(User::ROLE_SUPERVISOR)->get(),
            'config' => [
                'toolbar' => ['heading', 'bold', 'italic', 'strikethrough', '|', 'code', 'quote', 'unordered-list', 'ordered-list', 'horizontal-rule', '|', 'link', 'table', '|','preview', 'side-by-side'],
                'maxHeight' => '500px',
                'uploadImage' => false,
            ]
        ]);
    }
}
