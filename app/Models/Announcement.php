<?php

namespace App\Models;

use App\Http\Middleware\Teacher;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Mockery\Matcher\HasKey;

class Announcement extends Model
{
    use HasFactory;


    public const TYPE_OFFLINE = 0;
    public const TYPE_ONLINE = 1;
    public const STATUS_CLOSED = 0;
    public const STATUS_OPENED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'field',
        'module',
        'type',
        'location',
        'price',
        'status',
        'student_count',
    ];

    protected function type(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value === self::TYPE_ONLINE) {
                    return 'online';
                }
                if ($value === self::TYPE_OFFLINE) {
                    return 'offline';
                }
            },
            set: function ($value) {
                if ($value === 'online') {
                    return self::TYPE_ONLINE;
                }
                if ($value === 'offline') {
                    return self::TYPE_OFFLINE;
                }
            }
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value === self::STATUS_OPENED) {
                    return 'opened';
                }
                if ($value === self::STATUS_CLOSED) {
                    return 'closed';
                }
            },
            set: function ($value) {
                if ($value === 'opened') {
                    return self::STATUS_OPENED;
                }
                if ($value === 'closed') {
                    return self::STATUS_CLOSED;
                }
            }
        );
    }

    
    public function enroll(): HasMany
    {
        return $this->hasMany(Enroll::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function like(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reply(): HasMany
    {
        return $this->hasMany(reply::class);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) => $query->where(fn ($query) => $query->where('title', 'like', '%' . $search . '%')
                ->OrWhere('description', 'like', '%' . $search . '%'))
        );

        if (isset($filters['type'])) {
            if ($filters['type'] === 'offline') {
                $filters['type'] = 0;
            } elseif ($filters['type'] === 'online') {
                $filters['type'] = 1;
            }
        }


        $query->when(
            isset($filters['type']), // Check if 'type' filter is present
            function ($query) use ($filters) {
                $type = $filters['type']; // Get the value of 'type'
                $query->where('type', $type);
            }
        );
        $query->when(
            isset($filters['field']),
            function ($query) use ($filters) {
                $type = $filters['field'];
                $query->where('field', $type);
            }
        );

        $query->when(
            isset($filters['module']),
            function ($query) use ($filters) {
                $type = $filters['module'];
                $query->where('module', 'like', '%' . $type . '%');
            }
        );
    }
}
