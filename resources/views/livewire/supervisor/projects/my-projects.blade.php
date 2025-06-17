<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator>
        {{--        <x-slot:middle class="!justify-end">--}}
        {{--            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />--}}
        {{--        </x-slot:middle>--}}
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card shadow>
        <div class="mb-4">
            <x-button label="Create" class="btn-primary" link="{{ route('supervisor.projects.create') }}"/>
        </div>
        <x-table :headers="$headers" :rows="$projects" :sort-by="$sortBy" with-pagination>
            @scope('cell_student_id', $project)
            <span>{{ $project->student?->name }}</span>
            @endscope
            @scope('cell_moderator_id', $project)
            <span>{{ $project->moderator?->name }}</span>
            @endscope
            @scope('cell_examiner_id', $project)
            <span>{{ $project->examiner?->name }}</span>
            @endscope
            @scope('cell_status_text', $project)
            <x-badge :value="$project->status_text" class="badge-primary" />
            @endscope
            @scope('actions', $project)
            <div class="flex gap-2">
                <x-button icon="o-eye" link="{{ route('supervisor.projects.show', $project->getRouteKey()) }}" class="btn-ghost btn-sm text-primary" />
                <x-button icon="o-pencil" link="{{ route('supervisor.projects.edit', $project->getRouteKey()) }}" class="btn-ghost btn-sm text-primary" />
            </div>
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
