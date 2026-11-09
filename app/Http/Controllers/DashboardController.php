<?php

namespace App\Http\Controllers;

use App\Models\ResumeAnalysis;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $statistics = [
            'total_analyses' => ResumeAnalysis::query()->count(),
            'average_match_score' => number_format((float) ResumeAnalysis::query()->avg('match_score'), 0).'%',
            'high_matches' => ResumeAnalysis::query()->whereBetween('match_score', [80, 100])->count(),
            'low_matches' => ResumeAnalysis::query()->whereBetween('match_score', [0, 49])->count(),
        ];

        $recentAnalyses = ResumeAnalysis::query()
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('statistics', 'recentAnalyses'));
    }
}
