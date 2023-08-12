<?php

namespace App\Repository\News;

use App\Dtos\NewsDto;
use App\Http\Resources\NewsResource;
use App\Models\News;

interface INewsRepository
{
    public function listNews(?string $search): object;
    public function getNews(string $slug): NewsResource;
    public function createNews(NewsDto $newsDto): void;
    public function updateNews(string $slug, NewsDto $newsDto): void;
    public function deleteNews(string $slug): void;

}
