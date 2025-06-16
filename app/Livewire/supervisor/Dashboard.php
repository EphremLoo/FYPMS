<?php

namespace App\Livewire\supervisor;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.supervisor.dashboard');
    }
}
