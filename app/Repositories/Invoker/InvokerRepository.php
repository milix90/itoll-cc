<?php

namespace App\Repositories\Invoker;

use App\Models\Courier;
use App\Models\Invoker;
use App\Repositories\BaseRepository;

class InvokerRepository extends BaseRepository implements InvokerRepositoryAbstraction
{
    public function __construct(Invoker $model)
    {
        parent::__construct($model);
    }

    public function retrieveInvoker(string $identity): array
    {
        $invoker = $this->model
            ->where("identity_code", "=", $identity)
            ->first();


        return is_null($invoker) ? [] : $invoker->toArray();
    }
}
