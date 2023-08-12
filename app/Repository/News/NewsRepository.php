<?php

namespace App\Repository\News;

use App\Dtos\NewsDto;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Repository\News\INewsRepository;

class NewsRepository implements INewsRepository
{
    public function __construct(protected News $news)
    {
    }


    public function listNews(?string $search): object
    {
        $news=  $this->news
            ->with('category:id,name', 'user:id,name')
            ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })->paginate(10);

        return (object)[
            'news' => NewsResource::collection($news),
            'meta' => [
                'total' => $news->total(),
                'currentPage' => $news->currentPage(),
                'lastPage' => $news->lastPage(),
                'perPage' => $news->perPage(),
                'nextPageUrl' => $news->nextPageUrl(),
                'prevPageUrl' => $news->previousPageUrl(),
            ]
        ];
    }

    public function getNews(string $slug): NewsResource
    {
        $news = $this->news
            ->with('category:id,name', 'user:id,name', 'comments')
            ->where('slug', $slug)
            ->firstOrFail();

        return new NewsResource($news);
    }

    public function createNews(NewsDto $newsDto): void
    {
        $this->news->create((array)$newsDto);
    }

    public function updateNews(string $slug, NewsDto $newsDto): void
    {
        $news = $this->news->where('slug', $slug)->first();

        if ($news)  $news->update(array_filter((array)$newsDto));
    }

    public function deleteNews(string $slug): void
    {
        $this->news->where('slug', $slug)->delete();
    }
}
