<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supervisorProjects = [
            'Hospital management system',
            'Attendance management system',
            'Inventory management system',
            'Heart disease prediction',
            'Machine learning based medical diagnosis',
            'AI-powered Chatbot for Mental Health',
            'Human and Robot Detectors',
            'Twitter Sentiment Analysis',
        ];

        foreach ($supervisorProjects as $project) {
            $user = User::inRandomOrder()->role(User::ROLE_SUPERVISOR)->first();

            Project::create([
                'name' => $project,
                'description' => $project,
                'supervisor_id' => $user->id,
                'created_by' => $user->id,
            ]);
        }

        $projects = [
            'FYP management system',
            'Athletic management system',
            'Student management system',
            'Faculty management system',
            'HR management system',
            'Library management system',
            'School management system',
            'Sentiment Analysis Software for Businesses',
            ' Fraud Application Detector Software',
            'SMS Spam Filtering',
            'Face Detector Application',
            'Online Voting System',
            'Blockchain-based Supply Chain System',
            'Image Recognition with OpenCV',
            'AI-based Resume Screening System'
        ];
    }
}
