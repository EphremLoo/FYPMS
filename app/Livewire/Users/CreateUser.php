<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    use Toast;

    // You could use Livewire "form object" instead.
    #[Rule('required')]
    public string $name = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('nullable|confirmed')]
    public string $password = '';
    public string $password_confirmation = '';

    #[Rule('required')]
    public string $mmu_id = '';

    #[Rule('required|array|min:1')]
    public array $roles = [];

    public function save(): void
    {
        $data = $this->validate();

        $user = User::create($data);
        foreach ($data['roles'] as $role) {
            $user->assignRole(Role::findById($role));
        }

        // You can toast and redirect to any route
        $this->success('User created with success.', redirectTo: '/users');
    }

    public function render()
    {
        return view('livewire.users.create', [
            'rolesArray' => Role::all()->toArray(),
        ]);
    }
}
