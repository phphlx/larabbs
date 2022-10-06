<?php

namespace App\Admin\Repositories;

use App\Models\Salesperson as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Salesperson extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
