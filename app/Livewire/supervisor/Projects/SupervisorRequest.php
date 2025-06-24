<?php

namespace App\Livewire\supervisor\Projects;

use App\Models\SupervisorProjectRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class SupervisorRequest extends Component
{
    use Toast, WithPagination;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function accept(SupervisorProjectRequest $supervisorProjectRequest)
    {
        if ($supervisorProjectRequest->status === SupervisorProjectRequest::STATUS_APPROVED) {
            $this->error('Project request already accepted.');
            return;
        }

        // Update the status of the request first
        $supervisorProjectRequest->update(['status' => SupervisorProjectRequest::STATUS_APPROVED]);

        // Update the project with the supervisor ID
        $supervisorProjectRequest->project()->update(['supervisor_id' => $supervisorProjectRequest->supervisor_id]);
        
        $this->success('Request accepted successfully.');
    }

    public function reject(SupervisorProjectRequest $supervisorProjectRequest)
    {
        if ($supervisorProjectRequest->status === SupervisorProjectRequest::STATUS_REJECTED) {
            $this->error('Project request already rejected.');
            return;
        }

        // Update the status of the request
        $supervisorProjectRequest->update(['status' => SupervisorProjectRequest::STATUS_REJECTED]);

        $this->success('Request rejected successfully.');
    }

    public function render()
    {
        return view('livewire.supervisor.projects.supervisor-request', [
            'supervisorProjectRequests' => SupervisorProjectRequest::where('supervisor_id', auth()->id())
                ->latest()
                ->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'project_id', 'label' => 'Project'],
                ['key' => 'student_id', 'label' => 'Student'],
                ['key' => 'status_text', 'label' => 'Status'],
            ],
        ]);
    }
}
