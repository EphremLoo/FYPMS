<div>
    <x-header title="Update Project - {{ $project->name }}" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-markdown wire:model="description" label="Description" :config="$config" />

        {{-- <x-choices-offline
            label="Student"
            wire:model="student_id"
            :options="$students"
            placeholder="Search ..."
            single
            clearable
            searchable /> --}}

        <x-choices-offline
            label="Moderator"
            wire:model="moderator_id"
            :options="$moderators"
            placeholder="Search ..."
            single
            clearable
            searchable />

{{--        <x-choices-offline--}}
{{--            label="Examiner"--}}
{{--            wire:model="examiner_id"--}}
{{--            :options="$examiners"--}}
{{--            placeholder="Search ..."--}}
{{--            single--}}
{{--            clearable--}}
{{--            searchable />--}}

        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete({{ $project->getRouteKey() }})" wire:confirm="Are you sure? This process is cannot be undone." spinner class="btn-error mr-auto" />
            <x-button label="Cancel" link="{{ route('supervisor.projects.show', $project->getRouteKey()) }}" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
