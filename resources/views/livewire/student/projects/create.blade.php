<div>
    <x-header title="Create Project" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />

        <x-choices-offline
            label="Request Supervisor"
            wire:model="supervisor_id"
            :options="$supervisors"
            placeholder="Search..."
            single
            clearable
            searchable />

        <x-markdown wire:model="description" label="Description" :config="$config" />

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('student.projects.self') }}" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
