<?php

namespace App\Services\OrderCommand;

use App\Constants\Hooks;
use App\Repositories\Order\OrderRepositoryAbstraction;

class Deliver implements OrderCommandAbstraction
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
        $this->payload["status"] = Hooks::DELIVERED;
        return $this->orderRepository->updateOrder($this->payload, true);
    }
}
