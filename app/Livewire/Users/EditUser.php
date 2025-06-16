<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    use Toast;

    public User $user;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('nullable|confirmed')]
    public string $password = '';
    public string $password_confirmation = '';

    #[Rule('required')]
    public ?string $mmu_id = '';

    #[Rule('required|array|min:1')]
    public array $roles = [];

    public function mount(): void
    {
        $this->fill($this->user);
        $this->roles = $this->user->roles->pluck('id')->toArray();
    }

    public function save(): void
    {
        // Validate
        $data = $this->validate();

        // Update
        $this->user->update($data);
        $this->user->syncRoles([]);
        foreach ($data['roles'] as $role) {
            $this->user->assignRole(Role::findById($role));
        }

        // You can toast and redirect to any route
        $this->success('User updated with success.', redirectTo: '/users');
    }

    public function render()
    {
        return view('livewire.users.edit', [
            'rolesArray' => Role::all()->toArray(),
        ]);
    }
}
