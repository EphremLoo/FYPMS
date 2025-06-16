<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator>
{{--        <x-slot:middle class="!justify-end">--}}
{{--            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />--}}
{{--        </x-slot:middle>--}}
        <x-slot:actions>
            <x-button @click="$wire.drawer = true" responsive icon="o-funnel">
                Filters
                <x-badge wire:text="filterCount" class="badge-neutral badge-sm" />
            </x-button>
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card shadow>
        <div class="mb-4">
            <x-button label="Create" class="btn-primary" link="{{ route('users.create') }}" />
        </div>
        <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" with-pagination>
            @scope('cell_role', $user)
            @foreach($user->roles as $role)
                <x-badge :value="$role->name" class="badge-primary" />
            @endforeach
            @endscope
            @scope('actions', $user)
            <div class="flex gap-2">
                <x-button icon="o-pencil" link="{{ route('users.edit', $user->getRouteKey()) }}" class="btn-ghost btn-sm text-primary" />
            </div>
            @endscope
        </x-table>
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
