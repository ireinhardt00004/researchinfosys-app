<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedManuscript extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code', 'title','user_id','type','author','coordinator_id'
    ];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function coordinator(){
        return $this->belongsTo(User::class,'coordinator_id');
    }
}
