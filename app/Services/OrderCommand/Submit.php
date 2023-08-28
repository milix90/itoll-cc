<?php

namespace App\Services\OrderCommand;

use App\Repositories\Invoker\InvokerRepositoryAbstraction;
use App\Repositories\Order\OrderRepositoryAbstraction;

class Submit implements OrderCommandAbstraction
{
    private OrderRepositoryAbstraction $orderRepository;
    private InvokerRepositoryAbstraction $invokerRepository;
    private array $payload;

    public function __construct(
        OrderRepositoryAbstraction $repository,
        InvokerRepositoryAbstraction $courierRepo,
        array $payload
    ) {
        $this->orderRepository = $repository;
        $this->invokerRepository = $courierRepo;
        $this->payload = $payload;
    }

    public function handle(): array
    {
        $invoker = $this->invokerRepository->retrieveInvoker($this->payload["client"]);
        $this->payload["invoker_id"] = $invoker["invoker_id"];
        $this->payload["deliver_estimate"] = rand(30, 60);
        return $this->orderRepository->createOrder($this->payload);
    }
}
