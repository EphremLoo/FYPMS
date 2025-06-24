<div>
    <x-header title="Project - {{ $project->name }}" separator />

    <x-tabs wire:model="selectedTab">
        <x-tab name="project-details-tab" label="Project Details" icon="o-users">
            <x-card title="{{ $project->name }}" shadow separator class="mb-8">
                <span class="block mb-4">Supervisor: {{ $project->supervisor?->name }}</span>
                <span class="block mb-4">Moderator: {{ $project->moderator?->name }}</span>
{{--                <span class="block mb-4">Examiner: {{ $project->examiner?->name }}</span>--}}
                <span class="block mb-4">Student: {{ $project->student?->name }}</span>
                <span class="block mb-4">Created By: {{ $project->createdBy?->name }}</span>
                <span class="block mb-4">Status: <x-badge value="{{ $project->status_text }}" class="badge-primary" /></span>
                <span class="block mb-4">Supervisor Marks: {{ $project->supervisor_marks }}</span>
                <span class="block mb-4">Moderator Marks: {{ $project->moderator_marks }}</span>

                <x-hr />

                <span class="block mb-4 font-bold">Description</span>
                <div class="block">{!! \Illuminate\Support\Str::markdown(nl2br($project->description)) !!}</div>

                <x-slot:actions separator>
                    <x-button label="Back" link="{{ url()->previous() ?? route('supervisor.projects.self') }}" class="mr-auto" />
                    @if($project->supervisor_id == auth()->id() || $project->created_by == auth()->id())
                        <x-button label="Edit" icon="o-pencil" link="{{ route('supervisor.projects.edit', $project->getRouteKey()) }}" class="btn-primary" />
                    @endif
                </x-slot:actions>
            </x-card>
        </x-tab>
        @if ($project->createdBy->id == auth()->id() || $project->supervisor_id == auth()->id())
            <x-tab name="student-applications-tab" label="Student Applications" icon="o-sparkles">
                <!-- TABLE  -->
                <x-card title="Student Applications" shadow>
                    <x-table :headers="$studentHeaders" :rows="$studentProjectRequest" with-pagination>
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
            </x-tab>
        @endif

        @if ($project->createdBy->id == auth()->id() || $project->supervisor_id == auth()->id())
            <x-tab name="meeting-logs-tab" label="Meeting Logs" icon="o-clipboard">
                <div class="mb-4">
                    <x-button label="Create" class="btn-primary" link="{{ route('supervisor.projects.createmeetinglog', $project->getRouteKey()) }}" />
                </div>

                <!-- TABLE  -->
                <x-card title="Meeting Logs" shadow>
                    <x-table :headers="$logHeaders" :rows="$logs" with-pagination>
                        {{-- View Meeting Log --}}
                        @scope('actions', $log)
                            <x-button icon="o-eye" link="{{ route('supervisor.projects.showmeetinglog', ['project' => $log->project->getRouteKey(), 'meeting_log' => $log->getRouteKey()]) }}" class="btn-ghost btn-sm text-primary" />
                        @endscope
                    </x-table>
                </x-card>
            </x-tab>
        @endif

        <x-tab name="submission-tab" label="Submission" icon="c-arrow-up-on-square">
            @if(!empty($project->file))
                <a href="{{ $project->file }}" target="_blank" download class="btn btn-primary mb-4">Download Submitted Project</a>
            @else
                <span>There is no submission.</span>
            @endif
            <x-card Title="Project Marks" shadow>
                <x-form wire:submit="saveProjectMarks">
                    <x-input label="Marks" wire:model="supervisor_marks" type="number" />

                    <x-slot:actions>
                        <x-button label="Save" icon="o-paper-airplane" spinner="saveProjectMarks" type="submit" class="btn-primary" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        </x-tab>
    </x-tabs>

    <x-hr />

    @if ($project->createdBy->id == auth()->id() || $project->supervisor_id == auth()->id())
    {{-- Input comment --}}
    <x-header title="Comments" />

    <x-form wire:submit="save" no-separator>
        <x-textarea label="Comment" wire:model="text" rows="3" inline/>
        <x-slot:actions>
            <x-button label="Send" icon="o-paper-airplane" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>

    <br/>

    {{-- Display Comment --}}
    <x-card shadow>
        @forelse($comments as $comment)
            <div class="mb-4 flex justify-between items-start">
                <div>
                    <span class="block font-bold">
                        {{ $comment->createdBy->name }}
                        <span class="text-xs text-gray-500">({{ $project->created_at }}, {{ $comment->created_at->diffForHumans() }})</span>
                    </span>
                    <div class="block">{!! \Illuminate\Support\Str::markdown(nl2br($comment->text)) !!}</div>
                </div>
                @if ($comment->created_by == auth()->id())
                    <x-button icon="o-trash" wire:click="delete({{ $comment->getRouteKey() }})" wire:confirm="Are you sure you want to delete this comment?" class="btn-ghost btn-sm text-red-500 ml-4" />
                @endif
            </div>
            @if(!$loop->last)
                <x-hr />
            @endif
        @empty
            <div class="text-gray-500">No comments yet.</div>
        @endforelse
    </x-card>
    {{ $comments->links() }}
    @endif
</div>
