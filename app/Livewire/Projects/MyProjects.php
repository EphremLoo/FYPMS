<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class MyProjects extends Component
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
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.projects.my-projects', [
            'projects' => Project::where('created_by', auth()->id())->with('createdBy')->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', ],
                ['key' => 'name', 'label' => 'Name',],
                ['key' => 'status_text', 'label' => 'Status',],
                ['key' => 'student_id', 'label' => 'Student',],
                ['key' => 'supervisor_id', 'label' => 'Supervisor',],
                ['key' => 'created_by', 'label' => 'Created By',],
            ],
        ]);
    }
}
