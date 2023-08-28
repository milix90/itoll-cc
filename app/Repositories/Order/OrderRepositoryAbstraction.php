<?php

namespace App\Repositories\Order;

interface OrderRepositoryAbstraction
{
    public function retrieveOrderBulk(string $column, mixed $values, array $relations = []): array;

    public function retrieveOrder(string $column, mixed $value, array $relations = []): array;

    public function createOrder(array $payload): array;

    public function updateOrder(array $payload, bool $lock = false): array;
}
