<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'candidate_name',
    'match_score',
    'matching_skills',
    'skill_gaps',
    'interview_questions',
])]
class ResumeAnalysis extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'match_score' => 'integer',
            'matching_skills' => 'array',
            'skill_gaps' => 'array',
            'interview_questions' => 'array',
        ];
    }
}
