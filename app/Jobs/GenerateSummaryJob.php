<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\AIService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class GenerateSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $article;

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article)
    {
        //
         $this->article = $article;
    }

    /**
     * Execute the job.
     */
    public function handle(AIService $ai): void
    {
        //
        // $this->article->update(['summary' => $ai->generateSummary($this->article->content)]);
         $summary = $ai->generateSummary($this->article->content);

        if ($summary) {
            $this->article->update(['summary' => $summary]);
        }
    }
}
