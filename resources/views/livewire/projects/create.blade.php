<div>
    <x-header title="Create Project" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-markdown wire:model="description" label="Description" :config="$config" />
        <x-choices label="Student" wire:model="student_id" :options="$students" single clearable />
        <x-choices label="Moderator" wire:model="student_id" :options="$students" single clearable />
        <x-choices label="Supervisor" wire:model="student_id" :options="$students" single clearable />
        <x-choices label="Examiner" wire:model="student_id" :options="$students" single clearable />

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('projects.index') }}" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
