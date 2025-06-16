<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = ['status_text'];

    CONST STATUS_PROPOSED = 0;
    CONST STATUS_APPROVED = 1;
    CONST STATUS_REJECTED = 2;
    CONST STATUS_COMPLETED = 3;

    CONST STATUS_ARRAY = [
        self::STATUS_PROPOSED => 'Proposed',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_COMPLETED => 'Completed',
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
}
