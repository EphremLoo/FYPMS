<div>
    <x-header title="Project - {{ $project->name }}" separator />

    <x-tabs wire:model="selectedTab">
        <x-tab name="project-details-tab" label="Project Details" icon="o-users">
            <x-card title="{{ $project->name }}" shadow separator>
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
                    <x-button label="Back" link="{{ route('student.projects.self') }}" class="mr-auto" />
                    @if($project->student_id == auth()->id() || $project->created_by == auth()->id())
                        {{-- @if(false)
                            <x-button label="Meeting Logs" icon="o-clipboard" link="{{ route('student.projects.show', $project->getRouteKey()) }}" class="btn-primary" />
                        @endif --}}
                        <x-button label="Edit" icon="o-pencil" link="{{ route('student.projects.edit', $project->getRouteKey()) }}" class="btn-primary" />
                    @else
                        <x-button label="Apply" icon="o-paper-airplane" spinner="apply" wire:click="apply" wire:confirm="Are you sure?" class="btn-primary" />
                    @endif
                </x-slot:actions>
            </x-card>
        </x-tab>

        <x-tab name="meeting-logs-tab" label="Meeting Logs" icon="o-clipboard">

            <div class="mb-4">
                <x-button label="Create" class="btn-primary" link="{{ route('student.projects.createmeetinglog', $project->getRouteKey()) }}" />
            </div>

            <!-- TABLE  -->
            <x-card title="Meeting Logs" shadow>
                <x-table :headers="$logHeaders" :rows="$logs" with-pagination>
                    {{-- View Meeting Log --}}
                    @scope('actions', $log)
                        <x-button icon="o-eye" link="{{ route('student.projects.showmeetinglog', ['project' => $log->project->getRouteKey(), 'meeting_log' => $log->getRouteKey()]) }}" class="btn-ghost btn-sm text-primary" />
                    @endscope
                </x-table>
            </x-card>
        </x-tab>
    </x-tabs>    
</div>
