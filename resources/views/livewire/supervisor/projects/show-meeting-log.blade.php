<div>
    <x-header title="Project - {{ $project->name }}" separator />

    <x-card title="Meeting Log - {{ $meeting_log->meeting_no }}" shadow separator>
        <span class="block mb-4">Created By: {{ $meeting_log->createdBy->name }}</span>
        <span class="block mb-4">Created At: {{ \Carbon\Carbon::parse($meeting_log->created_at)->format('d/m/Y') }}</span>

        <x-hr/>
        <span class="block mb-4 font-bold">Work Done: </span>
        <div class="block">{{ $meeting_log->work_done }}</div>

        <br/>
        <br/>
        
        <span class="block mb-4 font-bold">Work To Do: </span>
        <div class="block">{{ $meeting_log->work_to_do }}</div>

        <br/>
        <br/>

        <span class="block mb-4 font-bold">Problems Encountered:</span>
        <div class="block">{{ $meeting_log->problems_encountered }}</div>

        <br/>
        <br/>

        <span class="block mb-4 font-bold">Comments:</span>
        <div class="block">{{ $meeting_log->comments }}</div>

        <x-slot:actions separator>
            <x-button label="Back" link="{{ route('supervisor.projects.show', $project->getRouteKey()) }}" class="mr-auto" />
            @if($project->student_id == auth()->id() || $project->created_by == auth()->id())
                <x-button label="Edit" icon="o-pencil" link="{{ route('supervisor.projects.editmeetinglog',['project' => $project->getRouteKey(), 'meeting_log' => $meeting_log->getRouteKey()]) }}" class="btn-primary" />
            @else
                <x-button label="Apply" icon="o-paper-airplane" spinner="apply" wire:click="apply" wire:confirm="Are you sure?" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-card>
</div>
