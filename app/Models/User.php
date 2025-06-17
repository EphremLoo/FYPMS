<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_STUDENT = 'student';
    const ROLE_SUPERVISOR = 'supervisor';
    const ROLE_EXAMINER = 'examiner';
    CONST ROLE_ARRAY = [
        self::ROLE_ADMIN => 'admin',
        self::ROLE_MODERATOR => 'moderator',
        self::ROLE_SUPERVISOR => 'supervisor',
        self::ROLE_EXAMINER => 'examiner',
        self::ROLE_STUDENT => 'student',
    ];

    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_REJECTED = 3;

    const STATUS_ARRAY = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_REJECTED => 'Rejected',
    ];
    const STATUS_ARRAY_COLOR = [
        self::STATUS_PENDING => 'badge-warning',
        self::STATUS_ACTIVE => 'badge-primary',
        self::STATUS_INACTIVE => 'badge-soft',
        self::STATUS_REJECTED => 'badge-error',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getStatusTextAttribute()
    {
        return self::STATUS_ARRAY[$this->status];
    }

    public function getStatusColorAttribute()
    {
        return self::STATUS_ARRAY_COLOR[$this->status];
    }

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
