<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateProject extends Component
{
    use Toast;

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

    public function save(): void
    {
        $data = $this->validate();

        $data['supervisor_id'] = auth()->id();
        $data['created_by'] = auth()->id();
        $data['year'] = now()->year;
        Project::create($data);

        $this->success('Project created with success.', redirectTo: route('supervisor.projects.self'));
    }

    public function render()
    {
        return view('livewire.supervisor.projects.create', [
            'students' => User::role(User::ROLE_STUDENT)->get(),
            'moderators' => User::role(User::ROLE_MODERATOR)->get(),
//            'examiners' => User::role(User::ROLE_EXAMINER)->get(),
            'config' => [
                'toolbar' => ['heading', 'bold', 'italic', 'strikethrough', '|', 'code', 'quote', 'unordered-list', 'ordered-list', 'horizontal-rule', '|', 'link', 'table', '|','preview', 'side-by-side'],
                'maxHeight' => '500px',
                'uploadImage' => false,
            ],
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
            'statuses' => [
                [
                    'id' => Project::STATUS_PROPOSED,
                    'name' => 'Proposed'
                ],
                [
                    'id' => Project::STATUS_APPROVED,
                    'name' => 'Approved'
                ],
                [
                    'id' => Project::STATUS_IN_PROGRESS,
                    'name' => 'In Progress'
                ],
                [
                    'id' => Project::STATUS_REJECTED,
                    'name' => 'Rejected'
                ],
                [
                    'id' => Project::STATUS_COMPLETED,
                    'name' => 'Completed'
                ],
            ],
        ]);
    }
}
