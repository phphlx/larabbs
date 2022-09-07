<?php

namespace App\Http\Queries;

use App\Models\Qun;
use Spatie\QueryBuilder\QueryBuilder;

class QunQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Qun::query());

        $this->allowedIncludes('user', 'user.roles');
    }
}
