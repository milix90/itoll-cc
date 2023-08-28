<?php

namespace App\Repositories\Courier;

interface CourierRepositoryAbstraction
{
    public function retrieveCourier(string $identity): array;
}
