<?php

namespace App\Livewire\Projects;

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

    #[Rule('required')]
    public string $student_id = '';

    #[Rule('required')]
    public string $supervisor_id = '';

    #[Rule('required')]
    public string $moderator_id = '';

    #[Rule('required')]
    public string $examiner_id = '';

    public function save(): void
    {
        $data = $this->validate();

        Project::create($data);

        $this->success('Project created with success.', redirectTo: '/projects');
    }

    public function render()
    {
        return view('livewire.projects.create', [
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
