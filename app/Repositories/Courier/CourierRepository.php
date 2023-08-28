<?php

namespace App\Repositories\Courier;

use App\Models\Courier;
use App\Repositories\BaseRepository;

class CourierRepository extends BaseRepository implements CourierRepositoryAbstraction
{
    public function __construct(Courier $model)
    {
        parent::__construct($model);
    }

    public function retrieveCourier(string $identity): array
    {
        return $this->model
            ->where("identity_code", "=", $identity)
            ->first()
            ->toArray();
    }
}
