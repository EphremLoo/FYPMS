<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class EditProject extends Component
{
    use Toast;

    public Project $project;

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

    public function mount(): void
    {
        $this->fill($this->project);
    }

    public function save(): void
    {
        if ($this->project->supervisor_id !== auth()->id() && $this->project->created_by !== auth()->id()) {
            $this->error("Cannot update project that does not belong to you or project that you are not supervising", redirectTo: route('supervisor.projects.edit', $this->project->getRouteKey()));
            return;
        }

        $data = $this->validate();

        $this->project->update($data);

        $this->success('Project updated with success.', redirectTo: route('supervisor.projects.show', $this->project->getRouteKey()));
    }

    public function delete(Project $project): void
    {
        $project->delete();
        $this->error("Deleting #$project->name", redirectTo: route('supervisor.projects.self'));
    }

    public function render()
    {
        if ($this->project->supervisor_id !== auth()->id() && $this->project->created_by !== auth()->id()) {
            abort(401, 'Unauthorized');
        }

        return view('livewire.supervisor.projects.edit', [
            'students' => User::role(User::ROLE_STUDENT)->get(),
            'moderators' => User::role(User::ROLE_MODERATOR)->get(),
//            'examiners' => User::role(User::ROLE_EXAMINER)->get(),
            'config' => [
                'toolbar' => ['heading', 'bold', 'italic', 'strikethrough', '|', 'code', 'quote', 'unordered-list', 'ordered-list', 'horizontal-rule', '|', 'link', 'table', '|','preview', 'side-by-side'],
                'maxHeight' => '500px',
                'uploadImage' => false,
            ],
        ]);
    }
}
