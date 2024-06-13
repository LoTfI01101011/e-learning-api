<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'announcement_id',
        'comment_id',
        'reply'
    ];
    public function user() : BelongsTo {
        return $this->belongsto(User::class);
    }
}
