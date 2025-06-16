<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowProject extends Component
{
    use Toast;

    public Project $project;

    public function mount(): void
    {
        $this->fill($this->project);
    }

    public function render()
    {
        return view('livewire.projects.show');
    }
}
