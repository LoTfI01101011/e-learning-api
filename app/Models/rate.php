<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'rate',
        'feedback'
    ];

    public function user() : BelongsTo {
        return $this->belongsto(User::class);
    }

}
