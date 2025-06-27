<?php

namespace App\Livewire\student\Projects;

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
    public ?int $project_type = 0;

    #[Rule('required')]
    public ?int $major = 0;

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
        if ($this->project->created_by !== auth()->id()) {
            $this->error("Cannot update project that does not belong to you", redirectTo: route('student.projects.edit', $this->project->getRouteKey()));
            return;
        }

        if ($this->project->status == Project::STATUS_APPROVED) {
            $this->error("Cannot update project once it has been approved.", redirectTo: route('student.projects.edit', $this->project->getRouteKey()));
            return;
        }

        $data = $this->validate();

        $this->project->update($data);

        $this->success('Project updated with success.', redirectTo: route('student.projects.show', $this->project->getRouteKey()));
    }

    public function delete(Project $project): void
    {
        if ($this->project->status == Project::STATUS_APPROVED) {
            $this->error("Cannot delete project once it has been approved.", redirectTo: route('student.projects.edit', $this->project->getRouteKey()));
            return;
        }

        $project->delete();
        $this->error("Deleting #$project->name", redirectTo: route('student.projects.index'));
    }

    public function render()
    {
        if ($this->project->student_id !== auth()->id() && $this->project->created_by !== auth()->id()) {
            abort(401, 'Unauthorized');
        }

        return view('livewire.student.projects.edit', [
            'students' => User::role(User::ROLE_STUDENT)->get(),
            'projectTypes' => [
                [
                    'id' => Project::project_type_application,
                    'name' => 'Application'
                ],
                [
                    'id' => Project::project_type_research,
                    'name' => 'Research'
                ],
                [
                    'id' => Project::project_type_hybrid,
                    'name' => 'Hybrid'
                ],
            ],   
            'majors' => [
                [
                    'id' => Project::major_software_engineering,
                    'name' => 'Software Engineering'
                ],
                [
                    'id' => Project::major_data_science,
                    'name' => 'Data Science'
                ],
                [
                    'id' => Project::major_game_development,
                    'name' => 'Game Development'
                ],
                [
                    'id' => Project::major_cybersecurity,
                    'name' => 'Cybersecurity'
                ],
            ],
            'config' => [
                'toolbar' => ['heading', 'bold', 'italic', 'strikethrough', '|', 'code', 'quote', 'unordered-list', 'ordered-list', 'horizontal-rule', '|', 'link', 'table', '|','preview', 'side-by-side'],
                'maxHeight' => '500px',
                'uploadImage' => false,
            ]
        ]);
    }
}
