<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProjectRequest extends Model
{
    /** @use HasFactory<\Database\Factories\StudentProjectRequestFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    CONST STATUS_PENDING = 'pending';
    CONST STATUS_APPROVED = 'approved';
    CONST STATUS_REJECTED = 'rejected';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
