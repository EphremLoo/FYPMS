<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- Project Request Table  -->
    <x-card shadow>
        <x-header title="Project Requests" size="text-xl" />
        <x-table :headers="$projectHeaders" :rows="$studentProjectRequests" :sort-by="$sortBy" with-pagination>
            @scope('cell_project_id', $studentProjectRequest)
            <span>{{ $studentProjectRequest->project->name }}</span>
            @endscope
            @scope('cell_status_text', $studentProjectRequest)
            <x-badge :value="$studentProjectRequest->status_text" class="badge-primary" />
            @endscope
            @scope('actions', $studentProjectRequest)
            @if($studentProjectRequest->status == \App\Models\StudentProjectRequest::STATUS_PENDING)
                <x-button label="Withdraw" wire:click="withdrawProjectRequest({{ $studentProjectRequest->getRouteKey() }})" wire:confirm="Are you sure? You will need to apply again if you withdraw your request." class="btn-error text-white" />
            @endif
            @endscope
        </x-table>
    </x-card>

    <br/>

    <!-- Supervisor Request Table  -->
    <x-card shadow>
        <x-header title="Supervisor Requests" size="text-xl" />
        <x-table :headers="$supervisorHeaders" :rows="$supervisorProjectRequests" :sort-by="$sortBy" with-pagination>
            @scope('cell_project_id', $supervisorProjectRequest)
            <span>{{ $supervisorProjectRequest->project->name }}</span>
            @endscope
            @scope('cell_supervisor_id', $supervisorProjectRequest)
            <span>{{ $supervisorProjectRequest->supervisor->name }}</span>
            @endscope
            @scope('cell_status_text', $supervisorProjectRequest)
            <x-badge :value="$supervisorProjectRequest->status_text" class="badge-primary" />
            @endscope
            @scope('actions', $supervisorProjectRequest)
            @if($supervisorProjectRequest->status == \App\Models\SupervisorProjectRequest::STATUS_PENDING)
                <x-button label="Withdraw" wire:click="withdrawSupervisorRequest({{ $supervisorProjectRequest->getRouteKey() }})" wire:confirm="Are you sure? You will need to request again if you withdraw your request." class="btn-error text-white" />
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
