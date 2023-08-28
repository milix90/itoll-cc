<?php

namespace App\Services\OrderCommand;

use App\Repositories\Order\OrderRepositoryAbstraction;

class Reclaim implements OrderCommandAbstraction
{
    private OrderRepositoryAbstraction $orderRepository;
    private array $payload;

    public function __construct(
        OrderRepositoryAbstraction $orderRepo,
        array $payload
    ) {
        $this->orderRepository = $orderRepo;
        $this->payload = $payload;
    }


    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->orderRepository->updateOrder($this->payload);
    }
}
