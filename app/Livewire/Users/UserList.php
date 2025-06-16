<?php

namespace App\Livewire\Users;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Mary\Traits\Toast;

class UserList extends Component
{
    use Toast;

    public $title = 'Users';

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.users.index', [
            'users' => User::paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
                ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
                ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
                ['key' => 'mmu_id', 'label' => 'MMU ID', 'sortable' => false],
            ],
        ]);
    }
}
