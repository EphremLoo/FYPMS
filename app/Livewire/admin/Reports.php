<?php

namespace App\Livewire\admin;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Reports extends Component
{
    use Toast, withPagination;

    public $title = 'Reports';

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

    public function render()
    {
        return view('livewire.admin.reports', [
            'users' => Report::when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))->orderBy(...array_values($this->sortBy))->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#',],
                ['key' => 'name', 'label' => 'Name',],
                ['key' => 'email', 'label' => 'Year'],
            ],
        ]);
    }
}
