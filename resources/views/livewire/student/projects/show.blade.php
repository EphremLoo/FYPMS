<div>
    <x-header title="Project - {{ $project->name }}" separator />

    <x-card title="{{ $project->name }}" shadow separator>
        <span class="block mb-4">Supervisor: {{ $project->supervisor?->name }}</span>
        <span class="block mb-4">Moderator: {{ $project->moderator?->name }}</span>
        <span class="block mb-4">Examiner: {{ $project->examiner?->name }}</span>
        <span class="block mb-4">Student: {{ $project->student?->name }}</span>
        <span class="block mb-4">Created By: {{ $project->createdBy?->name }}</span>
        <span class="block mb-4">Status: <x-badge value="{{ $project->status_text }}" class="badge-primary" /></span>

        <x-hr />

        <span class="block mb-4 font-bold">Description</span>
        <div class="block">{!! \Illuminate\Support\Str::markdown($project->description) !!}</div>

        <x-slot:actions separator>
            @if($project->student_id == auth()->id() || $project->created_by == auth()->id())
                <x-button label="Edit" icon="o-pencil" link="{{ route('student.projects.edit', $project->getRouteKey()) }}" class="btn-primary" />
            @else
                <x-button label="Apply" icon="o-paper-airplane" spinner="apply" wire:click="apply" wire:confirm="Are you sure?" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-card>
</div>
