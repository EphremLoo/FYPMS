<div>
    <x-header title="Create Project" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-markdown wire:model="description" label="Description" :config="$config" />

        @if(Auth()->user()->hasRole(\App\Models\User::ROLE_SUPERVISOR))
            <x-choices-offline
                label="Student"
                wire:model="student_id"
                :options="$students"
                placeholder="Search ..."
                single
                clearable
                searchable />
{{--            <x-choices-offline--}}
{{--                label="Supervisor"--}}
{{--                wire:model="supervisor_id"--}}
{{--                :options="$students"--}}
{{--                placeholder="Search ..."--}}
{{--                single--}}
{{--                clearable--}}
{{--                searchable />--}}

            <x-choices-offline
                label="Moderator"
                wire:model="moderator_id"
                :options="$students"
                placeholder="Search ..."
                single
                clearable
                searchable />

            <x-choices-offline
                label="Examiner"
                wire:model="examiner_id"
                :options="$students"
                placeholder="Search ..."
                single
                clearable
                searchable />
        @endif

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('projects.self') }}" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
