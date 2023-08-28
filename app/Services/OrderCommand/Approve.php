<?php

namespace App\Services\OrderCommand;

use App\Constants\Hooks;
use App\Repositories\Courier\CourierRepositoryAbstraction;
use App\Repositories\Order\OrderRepositoryAbstraction;

class Approve implements OrderCommandAbstraction
{
    private OrderRepositoryAbstraction $orderRepository;
    private CourierRepositoryAbstraction $courierRepository;
    private array $payload;

    public function __construct(
        OrderRepositoryAbstraction $orderRepo,
        CourierRepositoryAbstraction $courierRepo,
        array $payload
    ) {
        $this->orderRepository = $orderRepo;
        $this->courierRepository = $courierRepo;
        $this->payload = $payload;
    }


    /**
     * @return array
     */
    public function handle(): array
    {
        $order = $this->orderRepository
            ->retrieveOrder("order_code", $this->payload["order_uuid"])["data"];

        if (!is_null($order["courier_id"])) {
            return [
                __("custom.order_courier_modify"),
            ];
        }

        $this->payload["status"] = Hooks::ACCEPTED;
        $this->payload["courier_id"] = $this->courierRepository
            ->retrieveCourier($this->payload["client"])["courier_id"];


        return $this->orderRepository->updateOrder($this->payload);
    }
}
