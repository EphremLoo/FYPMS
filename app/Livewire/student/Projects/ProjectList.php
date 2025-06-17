<?php

namespace App\Livewire\student\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ProjectList extends Component
{
    use Toast, WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $title = 'Projects';


    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.');
    }

    public function render()
    {
        return view('livewire.student.projects.index', [
            'projects' => Project::with('createdBy')->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', ],
                ['key' => 'name', 'label' => 'Name',],
                ['key' => 'status_text', 'label' => 'Status',],
                ['key' => 'student_id', 'label' => 'Student',],
                ['key' => 'supervisor_id', 'label' => 'Supervisor',],
                ['key' => 'moderator_id', 'label' => 'Moderator',],
                ['key' => 'examiner_id', 'label' => 'Examiner',],
            ],
        ]);
    }
}
