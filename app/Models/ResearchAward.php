<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_research_program',
        'title_research_project',
        'project_leader_staff',
        'campus_college',
        'date_started',
        'date_completed',
        'research_title_award',
        'researcg_title_output',
        'researcher_award',
        'date_awarded_researcher',
        'venue',
        'awarding_body',
        'title_conference_symposium',
        'level',
        'user_id',
    ];
    
    
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
