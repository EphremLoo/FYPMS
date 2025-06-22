<div>
    <x-header title="Update Project - {{ $project->name }}" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-markdown wire:model="description" label="Description" :config="$config" />

        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete({{ $project->getRouteKey() }})" wire:confirm="Are you sure? This process is cannot be undone." spinner class="btn-error mr-auto" />
            <x-button label="Cancel" link="{{ route('student.projects.show', $project->getRouteKey()) }}" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
