<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_research_program',
        'title_research_project',
        'project_leader_staff',
        'campus_college',
        'date_started',
        'date_completed',
        'research_type',
        'article_title',
        'journal_name',
        'keywords',
        'authors',
        'volume_issue',
        'date_publication',
        'publication_type',
        'issn_isbn',
        'indexing_ched',
        'remarks_pub',
        'user_id',
    ];

    // If authors are stored as a JSON array, you can use casts to handle them as arrays
    protected $casts = [
        'authors' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
