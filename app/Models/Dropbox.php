<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
class Dropbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code', 
        'title',
        'user_id',
        'file_path',
        'comment',
        'status',
        
    ];

    protected $dates = ['deleted_at'];
    /**
     * Automatically generate a unique tracking code when creating a new manuscript.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($manuscript) {
            $year = date('Y');
            $courseID = Auth::user()->courseID;
            $sub = 'SUB';
            $monthMap = [
                1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D',
                5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H',
                9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L'
            ];
            $monthLetter = $monthMap[(int)date('n')];
            $randomString = strtoupper(Str::random(10));

            $trackingCode = "{$year}{$monthLetter}-{$courseID}-{$sub}-{$randomString}";

            $manuscript->tracking_code = $trackingCode;
        });
    }
  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
