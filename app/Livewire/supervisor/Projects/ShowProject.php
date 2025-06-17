<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\Project;
use App\Models\StudentProjectRequest;
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
        return view('livewire.supervisor.projects.show');
    }
}
