<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;

class UserInfo extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'user_id', 'profile_pic'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Set the profile picture.
     *
     * @param  string  $value
     * @return void
     */
    // public function setProfilePicAttribute($value)
    // {
    //     $this->attributes['profile_pic'] = Hash::make($value);
    // }

    /**
     * Get the user that owns the profile info.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
