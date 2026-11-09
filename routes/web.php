<?php

use Illuminate\Support\Facades\Route;

Route::view('/analyses/create', 'analyses.create')->name('analyses.create');

Route::get('/', function () {
    // Temporary UI preview data; replace with persisted statistics when the dashboard controller is added.
    return view('dashboard.index', [
        'statistics' => [
            'total_analyses' => '128',
            'average_match_score' => '74%',
            'high_matches' => '36',
            'low_matches' => '12',
        ],
        'recentAnalyses' => [
            [
                'id' => 1,
                'candidate_name' => 'Olivia Chen',
                'match_score' => 92,
                'matching_skills' => ['Product strategy', 'SQL', 'User research'],
                'created_at' => now()->subHours(2),
            ],
            [
                'id' => 2,
                'candidate_name' => 'Marcus Johnson',
                'match_score' => 76,
                'matching_skills' => ['Python', 'Data analysis', 'Communication'],
                'created_at' => now()->subHours(5),
            ],
            [
                'id' => 3,
                'candidate_name' => 'Priya Sharma',
                'match_score' => 48,
                'matching_skills' => ['Project management', 'Agile', 'Collaboration'],
                'created_at' => now()->subDay(),
            ],
            [
                'id' => 4,
                'candidate_name' => 'Daniel Kim',
                'match_score' => 84,
                'matching_skills' => ['Laravel', 'API design', 'Testing'],
                'created_at' => now()->subDays(2),
            ],
        ],
    ]);
});
