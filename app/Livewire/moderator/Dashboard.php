<?php

namespace App\Livewire\moderator;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.moderator.dashboard');
    }
}
