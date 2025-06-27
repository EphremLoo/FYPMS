<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = ['status_text'];

    CONST STATUS_PROPOSED = 0;
    CONST STATUS_APPROVED = 10;
    CONST STATUS_IN_PROGRESS = 20;
    CONST STATUS_REJECTED = 30;
    CONST STATUS_COMPLETED = 40;

    CONST STATUS_ARRAY = [
        self::STATUS_PROPOSED => 'Proposed',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_COMPLETED => 'Completed',
    ];
    
    CONST project_type_application = 0;
    CONST project_type_research = 1;
    CONST project_type_hybrid = 2;

    CONST PROJECT_TYPE_ARRAY = [
        self::project_type_application => 'Application',
        self::project_type_research => 'Research',
        self::project_type_hybrid => 'Hybrid',
    ];

    CONST major_software_engineering = 0;
    CONST major_data_science = 1;
    CONST major_game_development = 2;
    CONST major_cybersecurity = 3;

    CONST MAJOR_ARRAY = [
        self::major_software_engineering => 'Software Engineering',
        self::major_data_science => 'Data Science',
        self::major_game_development => 'Game Development',
        self::major_cybersecurity => 'Cybersecurity',
    ];

    public function getStatusTextAttribute()
    {
        return self::STATUS_ARRAY[$this->status];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function examiner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }

    public function meetingLogs(): HasMany
    {
        return $this->hasMany(MeetingLog::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class);
    }

    public function supervisorProjectRequests(): hasMany
    {
        return $this->hasMany(SupervisorProjectRequest::class);
    }

    public function updateTotalMarks(): void
    {
        $this->update([
            'total_marks' => ($this->supervisor_marks + $this->moderator_marks)/2,
        ]);
    }
}
