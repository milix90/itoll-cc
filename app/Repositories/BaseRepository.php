<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public Builder $model;

    public function __construct(Model $model)
    {
        $this->model = $model->query();
    }
}
