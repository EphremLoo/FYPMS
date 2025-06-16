<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class EditProject extends Component
{
    use Toast;

    public Project $project;

    // You could use Livewire "form object" instead.
    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public string $description = '';

    #[Rule('required')]
    public ?string $student_id = null;

    #[Rule('required')]
    public ?string $supervisor_id = null;

    #[Rule('required')]
    public ?string $moderator_id = null;

    #[Rule('required')]
    public ?string $examiner_id = null;

    public function mount(): void
    {
        $this->fill($this->project);
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->project->update($data);

        $this->success('Project updated with success.', redirectTo: '/projects');
    }

    public function delete(Project $project): void
    {
        $project->delete();
        $this->warning("Deleting #$project->name", position: 'toast-bottom', redirectTo: route('projects.index'));
    }

    public function render()
    {
        return view('livewire.projects.edit', [
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
