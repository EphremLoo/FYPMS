<?php

namespace App\Livewire\admin;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends Component
{
    use Toast, withPagination;

    public $title = 'Reports';

    public string $search = '';

    public int $filterCount = 0;

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->filterCount = 0;
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function updating($property, $value)
    {
        if ($property === 'search') {
            $this->filterCount++;
        }
    }

    public function generateReport()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Project Name');
        $sheet->setCellValue('B1', 'Student Name');
        $sheet->setCellValue('C1', 'Total Marks');
        $sheet->setCellValue('D1', 'Grade');
        $sheet->setCellValue('E1', 'Supervisor Name');;
        $sheet->setCellValue('F1', 'Moderator Name');;

        $projects = Project::where('year', now()->year)->whereNotNull('student_id')->whereNotNull('supervisor_id')->whereNotNull('moderator_id')->get();

        $row = 2; // Start from the second row
        foreach ($projects as $project) {
            $sheet->setCellValue('A' . $row, $project->name);
            $sheet->setCellValue('B' . $row, $project->student?->name);
            $sheet->setCellValue('C' . $row, $project->total_marks);
            $sheet->setCellValue('D' . $row, $project->grade);
            $sheet->setCellValue('E' . $row, $project->supervisor?->name);
            $sheet->setCellValue('F' . $row, $project->moderator?->name);
            $row++;
        }

        $fileName = 'Project_Report_' . now()->year . '.xlsx';
        $filePath = 'public/' . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/' . $filePath));

        Report::updateOrCreate([
            'name' => $fileName,
        ],
        [
            'file' => Storage::url($fileName),
            'year' => now()->year,
        ]);

        $this->success('Report generated successfully.', redirectTo: route('admin.reports.index'));
    }

    public function download(Report $report)
    {
        return Response()->download($report->file);
    }

    public function render()
    {
        return view('livewire.admin.reports', [
            'reports' => Report::when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))->orderBy(...array_values($this->sortBy))->latest()->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#',],
                ['key' => 'name', 'label' => 'Name',],
                ['key' => 'year', 'label' => 'Year'],
            ],
        ]);
    }
}
