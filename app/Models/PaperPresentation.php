<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperPresentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_paper_presentation',
        'authors',
        'keywords',
        'title_conference_symposium',
        'date',
        'venue',
        'organizer',
        'level',
        'user_id',
    ];
    
    
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

}
