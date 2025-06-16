<?php

namespace App\Livewire\student\Projects;

use App\Models\Project;
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
            $this->error('Students can only create a maximum of 3 projects', redirectTo: route('projects.create'));
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
        Project::create($data);

        $this->success('Project created with success.', redirectTo: route('student.projects.index'));
    }

    public function render()
    {
        return view('livewire.student.projects.create', [
            'students' => User::role(User::ROLE_STUDENT)->get(),
            'moderator' => User::role(User::ROLE_MODERATOR)->get(),
            'supervisor' => User::role(User::ROLE_SUPERVISOR)->get(),
            'examiner' => User::role(User::ROLE_EXAMINER)->get(),
            'config' => [
                'toolbar' => ['heading', 'bold', 'italic', 'strikethrough', '|', 'code', 'quote', 'unordered-list', 'ordered-list', 'horizontal-rule', '|', 'link', 'table', '|','preview', 'side-by-side'],
                'maxHeight' => '500px'
            ]
        ]);
    }
}
