<?php

namespace App\Livewire\Users;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class UserList extends Component
{
    use Toast, withPagination;

    public $title = 'Users';

    public string $search = '';

    public int $filterCount = 0;

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->filterCount = 0;
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function updating($property, $value)
    {
        if ($property === 'search') {
            $this->filterCount++;
        }
    }

    // Delete action
    public function delete(User $user): void
    {
        $user->delete();
        $this->warning("Deleting #$user->name", position: 'toast-bottom');
    }

    public function render()
    {
        return view('livewire.users.index', [
            'users' => User::when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
                ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
                ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
                ['key' => 'mmu_id', 'label' => 'MMU ID', 'sortable' => false],
                ['key' => 'role', 'label' => 'Roles', 'sortable' => false],
            ],
        ]);
    }
}
