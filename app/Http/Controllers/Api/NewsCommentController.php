<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsCommentRequest;
use App\Jobs\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(NewsCommentRequest $request, string $slug)
    {
        NewsComment::dispatch(
            content: $request->get('content'),
            slug: $slug,
            userName: auth()->user()->name
        );
    }
}
