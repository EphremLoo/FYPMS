<div>
    <!-- HEADER -->
    <x-header title="Supervisor Request" separator progress-indicator>
        {{-- <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions> --}}
    </x-header>

    <!-- TABLE  -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$supervisorProjectRequests" :sort-by="$sortBy" with-pagination>
            @scope('cell_project_id', $supervisorProjectRequest)
                {{ $supervisorProjectRequest->project->name }}
            @endscope
            @scope('cell_student_id', $supervisorProjectRequest)
                {{ $supervisorProjectRequest->student->name }}
            @endscope
            @scope('cell_status_text', $supervisorProjectRequest)
                <x-badge :value="$supervisorProjectRequest->status_text" class="badge-primary" />
            @endscope
            @scope('actions', $supervisorProjectRequest)
                <div class="flex gap-2">
                    <x-button icon="o-eye" link="{{ route('supervisor.projects.show', $supervisorProjectRequest->project->getRouteKey()) }}" class="btn-ghost btn-sm text-primary" />
                    @if($supervisorProjectRequest->status == \App\Models\SupervisorProjectRequest::STATUS_PENDING)
                        <x-button icon="o-check" class="btn-success btn-sm" wire:click="accept({{ $supervisorProjectRequest->id }})" wire:confirm="Do you want to accept this student?" />
                        <x-button icon="o-x-mark" class="btn-error btn-sm" wire:click="reject({{ $supervisorProjectRequest->id }})" wire:confirm="Do you want to reject this student?"/>
                    @endif
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
