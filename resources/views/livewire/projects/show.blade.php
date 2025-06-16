<div>
    <x-header title="Project - {{ $project->name }}" separator />

    <x-card title="{{ $project->name }}" shadow separator>
        <span class="block mb-4">Supervisor: {{ $project->supervisor?->name }}</span>
        <span class="block mb-4">Moderator: {{ $project->moderator?->name }}</span>
        <span class="block mb-4">Examiner: {{ $project->examiner?->name }}</span>
        <span class="block mb-4">Student: {{ $project->student?->name }}</span>
        <span class="block mb-4">Status: <x-badge value="{{ $project->status_text }}" class="badge-primary" /></span>

        <x-hr />

        <span class="block mb-4 font-bold">Description</span>
        <span class="block">{{ $project->description }}</span>

        <x-slot:actions separator>
            <x-button label="Back" link="{{ route('projects.index') }}" class="mr-auto" />
            <x-button label="Apply" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-card>
</div>
