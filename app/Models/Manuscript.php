<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Manuscript extends Model
{
    use HasFactory;
    protected $fillable = [
        'tracking_code', 
        'title',
        'author',
        'adviser',
        'technical_critic',
        'eng_critic',
        'file_path',
        'status',
        'section',
        'user_id',
        'coordinator_id',
        'project_leader_staff',
        'campus_college',
        'date_started',
        'date_completed',
        'fund_amount',
    ];


    /**
     * Automatically generate a unique tracking code when creating a new manuscript.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($manuscript) {
            $year = date('Y');
            $courseID = Auth::user()->courseID;
            $monthMap = [
                1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D',
                5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H',
                9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L'
            ];
            $monthLetter = $monthMap[(int)date('n')];
            $randomString = strtoupper(Str::random(10));

            $trackingCode = "{$year}{$monthLetter}-{$courseID}-{$randomString}";

            $manuscript->tracking_code = $trackingCode;
        });
    }

    /**
     * Mutator for storing the author as JSON.
     */
    public function setAuthorAttribute($value)
    {
        $this->attributes['author'] = json_encode($value);
    }

    /**
     * Accessor for retrieving the author as an array.
     */
    public function getAuthorAttribute($value)
    {
        return json_decode($value, true);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function subAdmin()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }
}
