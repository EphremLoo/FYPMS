<?php

namespace App\Livewire\admin;

use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
