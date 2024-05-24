<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use PDO;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const CATEGORY_STUDENT = 0;
    public const CATEGORY_TEACHER = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'category',
    ];

    // protected $with = [
    //     'profile','certificate','announcement','enroll','like','comment','reply'
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function category(): Attribute{
        return Attribute::make(
            get: function($value){
                if($value === self::CATEGORY_STUDENT){
                    return 'student';
                }
                if($value === self::CATEGORY_TEACHER){
                    return 'teacher';
                }
            },
            set: function($value){
                if($value === 'student'){
                    return self::CATEGORY_STUDENT;
                }
                if($value === 'teacher'){
                    return self::CATEGORY_TEACHER;
                }
            } 
        );
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);        
    }

    public function certificate(): HasMany
    {
        return $this->hasMany(Certificate::class);        
    }
    public function announcement(): HasMany
    {
        return $this->hasMany(Announcement::class);        
    }

    public function enroll(): HasMany
    {
        return $this->hasMany(Enroll::class);        
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

    public function rate(): HasMany
    {
        return $this->hasMany(rate::class);
    }



}
