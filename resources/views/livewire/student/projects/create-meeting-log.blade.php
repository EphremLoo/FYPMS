<div>
    {{-- Header --}}
    <x-header title="Create Meeting Log" separator />

    {{-- Form --}}
    <x-form wire:submit="save">
        <x-datetime wire:model="date_time" label="Date" />
        <x-textarea label="Work Done" wire:model="work_done" rows="5" />
        <x-textarea label="Work To Do" wire:model="work_to_do" rows="5" />
        <x-textarea label="Problems Encountered" wire:model="problems_encountered" rows="5" />
        <x-textarea label="Comments" wire:model="comments" rows="5" />

        <x-slot:actions>
            <x-button label="Cancel" link="{{ route('student.projects.show', $project->getRouteKey()) }}" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
