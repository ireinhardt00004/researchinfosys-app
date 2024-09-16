<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citation extends Model
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
        'article_title',
        'journal_name_book',
        'authors',
        'volume_no',
        'date_publication',
        'issn_isbn',
        'indexing_ched',
        'date_cited',
        'author_who_cited',
        'title_article_where_cited',
        'title_journal',
        'vol_issue_no',
        'date_published',
        'indexing_ched_that_cited',
        'user_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
