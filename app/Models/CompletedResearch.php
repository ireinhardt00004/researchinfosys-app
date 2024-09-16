<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedResearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_research_program',
        'title_research_project',
        'project_leader_staff',
        'campus_college',
        'date_started',
        'date_completed',
        'funding_cvsu',
        'funding_external',
        'ifnt_cvsu_research_type',
        'cooperating_agency',
        'thematic_area',
        'fund_amount',
        'user_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
