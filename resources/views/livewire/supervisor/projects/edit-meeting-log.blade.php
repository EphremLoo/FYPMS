<div>
    <x-header title="Update Meeting Log - {{ $meeting_log->meeting_no }}" separator />

    <x-form wire:submit="save">
        <x-markdown wire:model="work_done" label="Work Done" :config="$config" />
        <x-markdown wire:model="work_to_do" label="Work To Do" :config="$config" />
        <x-markdown wire:model="problems_encountered" label="Problems Encountered" :config="$config" />
        <x-markdown wire:model="comments" label="Comments" :config="$config" />

        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete({{ $meeting_log['id'] }})" wire:confirm="Are you sure?" spinner class="btn-error mr-auto" />
            <x-button label="Cancel" link="{{ route('supervisor.projects.showmeetinglog', ['project' => $project->getRouteKey(), 'meeting_log' => $meeting_log->getRouteKey()]) }}" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" spinner class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
