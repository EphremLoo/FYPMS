<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public function mount()
    {
        // It is logged in
        if (auth()->user() && auth()->user()->status === User::STATUS_ACTIVE) {
            if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_MODERATOR)) {
                return redirect()->route('moderator.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_SUPERVISOR)) {
                return redirect()->route('supervisor.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_STUDENT)) {
                return redirect()->route('student.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_EXAMINER)) {
                return redirect()->route('examiner.dashboard');
            }
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {

            if (auth()->user()->status !== User::STATUS_ACTIVE) {
                auth()->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                $this->addError('email', 'The provided credentials do not match our records.');
                return redirect()->route('login');
            }
            request()->session()->regenerate();

            if (auth()->user()->hasRole(User::ROLE_ADMIN)) {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_MODERATOR)) {
                return redirect()->route('moderator.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_SUPERVISOR)) {
                return redirect()->route('supervisor.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_STUDENT)) {
                return redirect()->route('student.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_EXAMINER)) {
                return redirect()->route('examiner.dashboard');
            }
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }

    #[Layout('components.layouts.guest')]       //  <-- Here is the `empty` layout
    public function render()
    {
        return view('livewire.auth.login');
    }
}
