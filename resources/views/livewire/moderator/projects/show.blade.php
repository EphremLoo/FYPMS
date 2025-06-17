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
        <div class="block">{!! \Illuminate\Support\Str::markdown($project->description) !!}</div>

        <x-slot:actions separator>
            <x-button label="Back" link="{{ route('moderator.projects.self') }}" class="mr-auto" />
            @if($project->supervisor_id == auth()->id() || $project->created_by == auth()->id())
                <x-button label="Edit" icon="o-pencil" link="{{ route('moderator.projects.edit', $project->getRouteKey()) }}" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-card>
</div>
