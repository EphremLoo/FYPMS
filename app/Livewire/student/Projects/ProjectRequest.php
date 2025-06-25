<?php

namespace App\Livewire\student\Projects;

use App\Models\StudentProjectRequest;
use App\Models\SupervisorProjectRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ProjectRequest extends Component
{
    use Toast, WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public $title = 'Requests';

    public function withdrawProjectRequest(StudentProjectRequest $studentProjectRequest)
    {
        if ($studentProjectRequest->status === StudentProjectRequest::STATUS_WITHDRAWN) {
            $this->error('Project request already withdrawn.');
        }

        $studentProjectRequest->update(['status' => StudentProjectRequest::STATUS_WITHDRAWN]);
        $totalApplications = $studentProjectRequest->project->total_applications - 1 < 0 ? 0 : $studentProjectRequest->project->total_applications - 1;
        $studentProjectRequest->project->update(['total_applications' => $totalApplications]);
        $this->success('Project withdrawn successfully.');
    }

    public function withdrawSupervisorRequest(SupervisorProjectRequest $supervisorProjectRequest)
    {
        if ($supervisorProjectRequest->status === SupervisorProjectRequest::STATUS_WITHDRAWN) {
            $this->error('Project request already withdrawn.');
        }

        $supervisorProjectRequest->update(['status' => SupervisorProjectRequest::STATUS_WITHDRAWN]);
        $this->success('Request withdrawn successfully.');
    }

    public function render()
    {
        return view('livewire.student.projects.project-requests', [
            'studentProjectRequests' => StudentProjectRequest::where('student_id', auth()->id())
                ->latest()
                ->paginate(10),
            'projectHeaders' => [
                ['key' => 'id', 'label' => '#', ],
                ['key' => 'project_id', 'label' => 'Project',],
                ['key' => 'status_text', 'label' => 'Status',],
            ],
            'supervisorProjectRequests' => SupervisorProjectRequest::where('student_id', auth()->id())
                ->latest()
                ->paginate(10),
            'supervisorHeaders' => [
                ['key' => 'id', 'label' => '#', ],
                ['key' => 'project_id', 'label' => 'Project',],
                ['key' => 'supervisor_id', 'label' => 'Supervisor',],
                ['key' => 'status_text', 'label' => 'Status',],
            ],
        ]);
    }
}
