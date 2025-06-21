<div>
    <x-header title="Update Meeting Log - {{ $meeting_log->meeting_no }}" separator />

    <x-form wire:submit="save">
        <x-textarea label="Work Done" wire:model="work_done" rows="5" />
        <x-textarea label="Work To Do" wire:model="work_to_do" rows="5" />
        <x-textarea label="Problems Encountered" wire:model="problems_encountered" rows="5" />
        <x-textarea label="Comments" wire:model="comments" rows="5" />

        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete({{ $meeting_log['id'] }})" wire:confirm="Are you sure?" spinner class="btn-error mr-auto" />
            <x-button label="Cancel" link="{{ route('student.projects.showmeetinglog', ['project' => $project->getRouteKey(), 'meeting_log' => $meeting_log->getRouteKey()]) }}" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" spinner class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
