<?php

namespace App\Http\Queries;

use App\Models\Article;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Article::query());

        $this->allowedIncludes('user', 'user.roles');
    }
}
