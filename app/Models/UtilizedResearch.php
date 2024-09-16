<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilizedResearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_research_program',
        'title_research_project',
        'project_leader_staff',
        'campus_college',
        'date_started',
        'date_completed',
        'ifnt_cvsu_research_type',
        'beneficiary_industry',
        'product_name_method',
        'brief_desc',
        'patent_utility',
        'initial_date_utilization',
        'development',
        'service',
        'utilization_others',
        'user_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
