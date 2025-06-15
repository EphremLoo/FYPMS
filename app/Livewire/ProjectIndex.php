<?php

namespace App\Livewire;

use Livewire\Component;

class ProjectIndex extends Component
{
    public $title;

    public function mount()
    {
        $this->title = __('Projects');
    }

    public function render()
    {
        return view('livewire.projects.project-index');
    }
}
