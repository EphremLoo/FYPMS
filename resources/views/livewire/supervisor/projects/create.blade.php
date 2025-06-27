<div>
    <x-header title="Create Project" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-select label="Project Type" wire:model="project_type" :options="$projectTypes" />
        <x-select label="Major" wire:model="major" :options="$majors" />
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
            <x-button label="Cancel" link="{{ route('supervisor.projects.self') }}" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
