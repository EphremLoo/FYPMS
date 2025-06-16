<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'status', 'student_id', 'moderator_id', 'supervisor_id', 'examiner_id', 'created_by'
    ];

    CONST STATUS_PROPOSED = 0;
    CONST STATUS_APPROVED = 1;
    CONST STATUS_REJECTED = 2;
    CONST STATUS_COMPLETED = 3;

    public static $STATUS_ARRAY = [
        self::STATUS_PROPOSED => 'Proposed',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_COMPLETED => 'Completed',
    ];
}
