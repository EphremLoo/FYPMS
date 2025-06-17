<?php

namespace App\Livewire\admin;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $title = 'Dashboard';

    public function render()
    {
        $totalUsers = User::count();
        $approvedUsers = User::where('status', User::STATUS_ACTIVE)->count();
        $rejectedUsers = User::where('status', User::STATUS_INACTIVE)->count();
        $pendingUsers = User::where('status', User::STATUS_PENDING)->count();

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'approvedUsers' => $approvedUsers,
            'rejectedUsers' => $rejectedUsers,
            'pendingUsers' => $pendingUsers,
        ]);
    }
}
