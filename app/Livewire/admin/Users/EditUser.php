<?php

namespace App\Livewire\admin\Users;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;
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

    #[Rule('required')]
    public int $status = 0;

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
        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Update
        $this->user->update($data);
        $this->user->syncRoles([]);
        foreach ($data['roles'] as $role) {
            $this->user->assignRole(Role::findById($role));
        }

        // You can toast and redirect to any route
        $this->success('User updated with success.', redirectTo: route('admin.users.index'));
    }

    // Delete action
    public function delete(User $user): void
    {
        $user->delete();
        $this->warning("Deleting #$user->name", position: 'toast-bottom', redirectTo: route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.users.edit', [
            'rolesArray' => Role::all()->toArray(),
            'statuses' => [
                [
                    'id' => User::STATUS_PENDING,
                    'name' => 'Pending'
                ],
                [
                    'id' => User::STATUS_ACTIVE,
                    'name' => 'Active'
                ],
                [
                    'id' => User::STATUS_INACTIVE,
                    'name' => 'Inactive'
                ],
                [
                    'id' => User::STATUS_REJECTED,
                    'name' => 'Rejected'
                ]
            ],
        ]);
    }
}
