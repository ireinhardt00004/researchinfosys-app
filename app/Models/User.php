<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'studnum',
        'lname',
        'middlename',
        'fname',
        'roles',
        'courseID',
        'sex',
        'email',
        'password',
        'verified',
    ];

    protected $dates=['deleted_at'];
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

    public function hasRole($roles)
    {
        return $this->roles === $roles;
    }

    public function userinfos()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function activitylogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = "%{$value}%";

        $query->where('lname', 'like', $value)
              ->orWhere('middlename', 'like', $value)
              ->orWhere('fname', 'like', $value)
              ->orWhere('roles', 'like', $value);
    }

}
