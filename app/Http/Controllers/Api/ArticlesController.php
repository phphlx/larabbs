<?php

namespace App\Http\Controllers\Api;

use App\Http\Queries\ArticleQuery;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request, ArticleQuery $query)
    {
        $topics = $query->latest()->paginate();

        return ArticleResource::collection($topics);
    }
}
