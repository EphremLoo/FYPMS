<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class Register extends Component
{
    #[Rule('required')]
    public string $name = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|confirmed')]
    public string $password = '';
    public string $password_confirmation = '';

    #[Rule('required')]
    public string $mmu_id = '';


    public function register()
    {
        $data = $this->validate();

        User::create($data);

        $this->success('Registration success. Please wait for admin to approve account.', redirectTo: '/register');
    }

    #[Layout('components.layouts.guest')]       //  <-- Here is the `empty` layout
    public function render()
    {
        return view('livewire.auth.register');
    }
}
