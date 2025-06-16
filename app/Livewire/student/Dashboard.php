<?php

namespace App\Livewire\student;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
