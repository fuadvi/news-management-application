<?php

namespace App\Jobs;

use App\Dtos\NewsCommentDto;
use App\Repository\News\INewsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewsComment implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $content,
        protected string $slug,
        protected string $userName,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(INewsRepository $newsRepo): void
    {
        $newsRepo->createComment(
            NewsCommentDto::fromRequest($this->content, $this->slug, $this->userName)
        );
    }

}
