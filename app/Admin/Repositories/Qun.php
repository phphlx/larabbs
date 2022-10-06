<?php

namespace App\Admin\Repositories;

use App\Models\Qun as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Qun extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
