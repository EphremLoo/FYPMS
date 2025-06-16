<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$studentProjectRequests" :sort-by="$sortBy" with-pagination>
            @scope('cell_project_id', $studentProjectRequest)
            <span>{{ $studentProjectRequest->project->name }}</span>
            @endscope
            @scope('cell_status_text', $studentProjectRequest)
            <x-badge :value="$studentProjectRequest->status_text" class="badge-primary" />
            @endscope
            @scope('actions', $studentProjectRequest)
            @if($studentProjectRequest->status == \App\Models\StudentProjectRequest::STATUS_PENDING)
                <x-button label="Withdraw" wire:click="withdraw({{ $studentProjectRequest->getRouteKey() }})" wire:confirm="Are you sure? You will need to apply again if you withdraw your request." class="btn-error text-white" />
            @endif
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
