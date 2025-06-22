<div>
    {{-- Header --}}
    <x-header title="Create Meeting Log" separator />

    {{-- Form --}}
    <x-form wire:submit="save">
        <x-datetime wire:model="date_time" label="Date" />
        <x-markdown wire:model="work_done" label="Work Done" :config="$config" />
        <x-markdown wire:model="work_to_do" label="Work To Do" :config="$config" />
        <x-markdown wire:model="problems_encountered" label="Problems Encountered" :config="$config" />
        <x-markdown wire:model="comments" label="Comments" :config="$config" />

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('student.projects.show', $project->getRouteKey()) }}" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
