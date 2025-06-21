<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator />

    <!-- TABLE  -->
    <x-card shadow>
        <div class="mb-4">
            <x-button label="Create" class="btn-primary" link="{{ route('student.projects.createmeetinglog', $project->getRouteKey()) }}" />
        </div>
        
        <x-table :headers="$headers" :rows="$logs" :sort-by="$sortBy" with-pagination>
            {{-- View Meeting Log --}}
            @scope('actions', $log)
                <x-button icon="o-eye" link="{{ route('student.projects.showmeetinglog', ['project' => $log->project->getRouteKey(), 'meeting_log' => $log->getRouteKey()]) }}" class="btn-ghost btn-sm text-primary" />
            @endscope
            {{-- Edit Meeting Log --}}
            {{-- @scope('actions', $user)
                <x-button icon="o-pencil" link="{{ route('admin.users.edit', $user->getRouteKey()) }}" class="btn-ghost btn-sm text-primary" />
            @endscope --}}
        </x-table>

        <x-button label="Back" link="{{ route('student.projects.show', $project->getRouteKey()) }}" class="mr-auto" />
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <div class="grid gap-5">
            <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
        </div>

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
