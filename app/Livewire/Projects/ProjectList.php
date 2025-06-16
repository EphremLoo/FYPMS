<?php

namespace App\Livewire\Projects;

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
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.projects.index', [
            'projects' => Project::paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', ],
                ['key' => 'name', 'label' => 'Name',],
                ['key' => 'status', 'label' => 'Status',],
            ],
        ]);
    }
}
