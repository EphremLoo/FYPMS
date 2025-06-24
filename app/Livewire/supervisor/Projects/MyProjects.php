<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class MyProjects extends Component
{
    use Toast, WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public $title = 'My Projects';


    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.');
    }

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (! is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.supervisor.projects.my-projects', [
            'projects' => Project::where('created_by', auth()->id())->orWhere('supervisor_id', auth()->id())->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))->orderBy(...array_values($this->sortBy))->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', ],
                ['key' => 'name', 'label' => 'Name',],
                ['key' => 'status', 'label' => 'Status',],
                ['key' => 'student_id', 'label' => 'Student',],
                ['key' => 'supervisor_id', 'label' => 'Supervisor',],
                ['key' => 'moderator_id', 'label' => 'Moderator',],
//                ['key' => 'examiner_id', 'label' => 'Examiner',],
                ['key' => 'created_by', 'label' => 'Created By',],
            ],
        ]);
    }
}
