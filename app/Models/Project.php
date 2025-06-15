<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;

    public $fillable = [
        'status', 'student_id', 'moderator_id', 'supervisor_id', 'examiner_id', 'created_by',
    ];

    CONST STATUS_PENDING = 0;
    CONST STATUS_APPROVED = 1;
    CONST STATUS_REJECTED = 2;

    CONST STATUS_TEXT = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];
}
