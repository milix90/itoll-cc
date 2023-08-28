<?php

namespace App\Services\OrderCommand;

use App\Constants\Hooks;
use App\Repositories\Order\OrderRepositoryAbstraction;

class Receive implements OrderCommandAbstraction
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

    public function handle(): array
    {
        $this->payload["status"] = Hooks::RECEIVED;
        return $this->orderRepository->updateOrder($this->payload, true);
    }
}
