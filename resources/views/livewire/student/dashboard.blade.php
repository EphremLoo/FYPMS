<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator>

    </x-header>

{{--    <!-- TABLE  -->--}}
{{--    <x-card shadow>--}}
{{--        <div class="mb-4">--}}
{{--            <x-button label="Create" class="btn-primary" />--}}
{{--        </div>--}}
{{--        <x-table :headers="$headers" :rows="$projects" :sort-by="$sortBy" with-pagination>--}}
{{--            @scope('actions', $user)--}}
{{--            <x-button icon="o-trash" wire:click="delete({{ $user->id }})" wire:confirm="Are you sure?" spinner class="btn-ghost btn-sm text-error" />--}}
{{--            @endscope--}}
{{--        </x-table>--}}
{{--    </x-card>--}}

{{--    <!-- FILTER DRAWER -->--}}
{{--    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">--}}
{{--        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />--}}

{{--        <x-slot:actions>--}}
{{--            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />--}}
{{--            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />--}}
{{--        </x-slot:actions>--}}
{{--    </x-drawer>--}}
</div>
