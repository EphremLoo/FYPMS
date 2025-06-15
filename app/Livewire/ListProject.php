<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Mary\Traits\Toast;

class ListProject extends Component
{
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
