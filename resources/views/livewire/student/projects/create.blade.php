<div>
    <x-header title="Create Project" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-select label="Project Type" wire:model="project_type" :options="$projectTypes" />
        <x-select label="Major" wire:model="major" :options="$majors" />

        <x-markdown wire:model="description" label="Description" :config="$config" />

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('student.projects.self') }}" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
