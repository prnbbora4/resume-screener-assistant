<?php

namespace App\Jobs;

use App\Models\ResumeAnalysis;
use App\Services\OpenAiResumeAnalysisService;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class AnalyzeResumeJob implements ShouldBeEncrypted, ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public string $trackingId,
        public string $candidateName,
        public string $jobDescription,
        public string $resume,
    ) {}

    /**
     * Process an analysis without retaining the source documents after execution.
     */
    public function handle(OpenAiResumeAnalysisService $analysisService): void
    {
        $cacheKey = $this->cacheKey();
        Cache::put($cacheKey, [
            'status' => 'processing',
            'message' => 'Your resume and job description are being analyzed.',
        ], now()->addDay());

        $report = $analysisService->analyze($this->jobDescription, $this->resume);

        $analysis = ResumeAnalysis::create([
            'candidate_name' => $this->candidateName,
            ...$report,
        ]);

        Cache::put($cacheKey, [
            'status' => 'completed',
            'analysis_id' => $analysis->id,
        ], now()->addDay());

        $this->forgetSourceDocuments();
    }

    /**
     * Mark an exhausted job as failed without exposing provider details or input text.
     */
    public function failed(?Throwable $exception): void
    {
        Cache::put($this->cacheKey(), [
            'status' => 'failed',
            'message' => 'We could not complete this analysis. Please try again later.',
        ], now()->addDay());

        Log::warning('Resume analysis job failed.', [
            'tracking_id' => $this->trackingId,
            'exception' => $exception !== null ? $exception::class : null,
        ]);

        $this->forgetSourceDocuments();
    }

    private function cacheKey(): string
    {
        return 'resume-analysis:'.$this->trackingId;
    }

    private function forgetSourceDocuments(): void
    {
        $this->jobDescription = '';
        $this->resume = '';
        $this->candidateName = '';
    }
}
