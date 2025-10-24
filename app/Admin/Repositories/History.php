<?php

namespace App\Admin\Repositories;

use App\Models\History as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class History extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
