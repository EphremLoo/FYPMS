<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProjectRequest extends Model
{
    /** @use HasFactory<\Database\Factories\StudentProjectRequestFactory> */
    use HasFactory;

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

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getStatusTextAttribute()
    {
        return self::STATUS_ARRAY[$this->status];
    }
}
