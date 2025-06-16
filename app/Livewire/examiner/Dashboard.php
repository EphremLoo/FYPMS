<?php

namespace App\Livewire\examiner;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.examiner.dashboard');
    }
}
