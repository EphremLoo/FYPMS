<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisorProjectRequest extends Model
{
    protected $guarded = ['id'];
    
    CONST STATUS_PENDING = 0;
    CONST STATUS_APPROVED = 1;
    CONST STATUS_REJECTED = 2;
    CONST STATUS_WITHDRAWN = 3;

    CONST STATUS_ARRAY = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_WITHDRAWN => 'Withdrawn',
    ];

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function supervisor() :BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function student() :BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }   

    public function getStatusTextAttribute() :string
    {
        return self::STATUS_ARRAY[$this->status];
    }

    // studentid == 1, supervisorid == 1
    // studentid == 1, supervisorid == 2 // where supervisor_id is not null

    // studentid == 1, supervisorid == null // where null supervisor_id

    // $project->studentProjectRequest()->whereNull('supervisor_id')->first(); if i make table this will probably not be used and will need to be changed
    // $project->studentProjectRequest()->whereNull('student_id')->first();
}
