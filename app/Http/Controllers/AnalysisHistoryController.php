<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoryFilterRequest;
use App\Models\ResumeAnalysis;
use Illuminate\Contracts\View\View;

class AnalysisHistoryController extends Controller
{
    public function index(HistoryFilterRequest $request): View
    {
        $filters = $request->validated();

        $analyses = ResumeAnalysis::query()
            ->when(
                filled($filters['search'] ?? null),
                fn ($query) => $query->where('candidate_name', 'like', '%'.addcslashes($filters['search'], '%_\\').'%'),
            )
            ->when(
                isset($filters['min_score']),
                fn ($query) => $query->where('match_score', '>=', $filters['min_score']),
            )
            ->when(
                isset($filters['max_score']),
                fn ($query) => $query->where('match_score', '<=', $filters['max_score']),
            )
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('history.index', compact('analyses'));
    }
}
