<div>
    <x-header title="Project - {{ $project->name }}" separator />

    <x-card title="{{ $project->name }}" shadow separator class="mb-8">
        <span class="block mb-4">Supervisor: {{ $project->supervisor?->name }}</span>
        <span class="block mb-4">Moderator: {{ $project->moderator?->name }}</span>
        <span class="block mb-4">Examiner: {{ $project->examiner?->name }}</span>
        <span class="block mb-4">Student: {{ $project->student?->name }}</span>
        <span class="block mb-4">Created By: {{ $project->createdBy?->name }}</span>
        <span class="block mb-4">Status: <x-badge value="{{ $project->status_text }}" class="badge-primary" /></span>

        <x-hr />

        <span class="block mb-4 font-bold">Description</span>
        <div class="block">{!! \Illuminate\Support\Str::markdown(nl2br($project->description)) !!}</div>

        <x-slot:actions separator>
            <x-button label="Back" link="{{ route('supervisor.projects.index') }}" class="mr-auto" />
            @if($project->supervisor_id == auth()->id() || $project->created_by == auth()->id())
                <x-button label="Edit" icon="o-pencil" link="{{ route('supervisor.projects.edit', $project->getRouteKey()) }}" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-card>

    <!-- TABLE  -->
    <x-card title="Student Applications" shadow>
        <x-table :headers="$headers" :rows="$studentProjectRequest" with-pagination>
            @scope('cell_student_id', $studentProjectRequest)
            <span>{{ $studentProjectRequest->student?->name }}</span>
            @endscope
            @scope('cell_status', $studentProjectRequest)
            <x-badge value="{{ $studentProjectRequest->status_text }}" class="badge-primary" />
            @endscope
            @scope('actions', $studentProjectRequest)
                @if($studentProjectRequest->project->created_by == auth()->id() && !in_array($studentProjectRequest->status, [\App\Models\StudentProjectRequest::STATUS_WITHDRAWN, \App\Models\StudentProjectRequest::STATUS_APPROVED, \App\Models\StudentProjectRequest::STATUS_REJECTED]))
                    <div class="flex gap-4">
                        <x-button label="Reject" wire:click="reject({{ $studentProjectRequest->getRouteKey() }})" wire:confirm="Are you sure?" class="btn-error" />
                        <x-button label="Approve" wire:click="approve({{ $studentProjectRequest->getRouteKey() }})" wire:confirm="Are you sure?" class="btn-success" />
                    </div>
                @endif
            @endscope
        </x-table>
    </x-card>
</div>
