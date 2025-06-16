<?php

namespace App\Livewire\students;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
