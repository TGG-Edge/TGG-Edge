<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\AIService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateSlugJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $article;

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
        // $this->article->update(['slug' => $ai->generateSlug($this->article->title)]);
        $slug = $ai->generateSlug($this->article->title, $this->article->content);

        if ($slug) {
            $this->article->update(['slug' => \Str::slug($slug)]);
        }
    }
}
