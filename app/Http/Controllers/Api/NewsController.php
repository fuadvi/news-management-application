<?php

namespace App\Http\Controllers\Api;

use App\Dtos\NewsDto;
use App\Events\NewsCreated;
use App\Events\NewsDeleted;
use App\Events\NewsUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Repository\News\INewsRepository;
use App\Traits\ImageTrait;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    use ResponseAPI;
    use ImageTrait;
    public function __construct(
        protected INewsRepository $newsRepo
    )
    {
        $this->middleware('is.admin')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->success("List News", $this->newsRepo->listNews($request->search));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        try {

            DB::beginTransaction();

            if ($request->hasFile('images')) {
                $request->images = $this->uploadImage($request->file('images'), 'news');
            }

            $news = $this->newsRepo->createNews(
                NewsDto::fromRequest($request)
            );

            NewsCreated::dispatch($news);
            DB::commit();

            return $this->success("News Created", null, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->success("Detail News", $this->newsRepo->getNews($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsUpdateRequest $request, string $slug)
    {
        try {
            DB::beginTransaction();

            $news = $this->newsRepo->getNews($slug);

            if ($request->hasFile('images') && $news->images) {
                $this->deleteImage($news->images);
                $request->images = $this->uploadImage($request->file('images'), 'news');
            }

            $news = $this->newsRepo->updateNews($news->slug, NewsDto::fromRequest($request));

            NewsUpdated::dispatch($news);
            DB::commit();

            return $this->success("News Updated", null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $news = $this->newsRepo->getNews($slug);

        NewsDeleted::dispatch($news);

        if ($news->images) $this->deleteImage($news->images);

        $this->newsRepo->deleteNews($news->slug);
        return $this->success("News Deleted", null, 204);
    }
}
