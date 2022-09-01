<?php

namespace App\Http\Queries;

use App\Models\Video;
use Spatie\QueryBuilder\QueryBuilder;

class VideoQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Video::query());

        $this->allowedIncludes('user', 'user.roles');
    }
}
