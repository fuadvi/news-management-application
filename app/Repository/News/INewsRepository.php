<?php

namespace App\Repository\News;

use App\Dtos\NewsCommentDto;
use App\Dtos\NewsDto;
use App\Http\Resources\NewsResource;
use App\Models\News;

interface INewsRepository
{
    public function listNews(?string $search): object;
    public function getNews(string $slug): NewsResource;
    public function createNews(NewsDto $newsDto): News;
    public function updateNews(string $slug, NewsDto $newsDto): News;
    public function deleteNews(string $slug): void;
    public function createComment(NewsCommentDto $newsDto);

}
