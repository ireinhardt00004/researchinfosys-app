<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventionUtility extends Model
{
    protected $fillable = [
        'title_research_program',
        'title_research_project',
        'project_leader_staff',
        'campus_college',
        'date_started',
        'date_completed',
        'ifnt_cvsu_research_type',
        'title_invention_utility_model',
        'patent_number',
        'date_of_issue',
        'utilization_invention_development',
        'utilization_invention_service',
        'name_commercial_product',
        'points',
        'user_id',
    ];
    
    
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
