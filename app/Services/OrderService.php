<?php

namespace App\Services;

use App\Constants\Hooks;
use App\Constants\Revokers;
use App\Models\Courier;
use App\Models\Invoker;
use App\Models\Order;
use App\Services\OrderCommand\Receive;
use App\Services\OrderCommand\Deliver;
use App\Services\OrderCommand\Reclaim;
use App\Repositories\{
    Courier\CourierRepository,
    Invoker\InvokerRepository,
};
use App\Repositories\{
    Courier\CourierRepositoryAbstraction,
    Invoker\InvokerRepositoryAbstraction,
};
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryAbstraction;
use App\Services\OrderCommand\Approve;
use App\Services\OrderCommand\InvokeOrder;
use App\Services\OrderCommand\Revoke;
use App\Services\OrderCommand\Submit;
use Illuminate\Support\Facades\Redis;

class OrderService
{
    private OrderRepositoryAbstraction $orderRepo;
    private CourierRepositoryAbstraction $courierRepo;
    private InvokerRepositoryAbstraction $invokerRepo;
    private InvokeOrder $invokeOrder;

    public function __construct()
    {
        $this->orderRepo = new OrderRepository(new Order);
        $this->courierRepo = new CourierRepository(new Courier);
        $this->invokerRepo = new InvokerRepository(new Invoker);
        $this->invokeOrder = new InvokeOrder();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function available(array $payload): array
    {
        $availableOrders = Redis::command("keys", ["*"]);
        return $this->orderRepo->retrieveOrderBulk("order_code", $availableOrders);
    }

    /**
     * @param array $payload
     * @return array
     */
    public function inquire(array $payload): array
    {
        return $this->orderRepo->retrieveOrder("order_code", $payload["order_uuid"]);
    }

    /**
     * @param array $payload
     * @return array
     */
    public function submit(array $payload): array
    {
        $submit = new Submit($this->orderRepo, $this->invokerRepo, $payload);
        $command = $this->invokeOrder->setCommand($submit);
        return $command->run();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function approve(array $payload): array
    {
        $approve = new Approve($this->orderRepo, $this->courierRepo, $payload);
        $command = $this->invokeOrder->setCommand($approve);
        return $command->run();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function revoke(array $payload): array
    {
        $payload["status"] = Hooks::REVOKED;
        $payload["revoker_id"] = Revokers::INVOKER;
        $revoke = new Revoke($this->orderRepo, $payload);
        $command = $this->invokeOrder->setCommand($revoke);
        return $command->run();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function receive(array $payload): array
    {
        $receive = new Receive($this->orderRepo, $payload);
        $command = $this->invokeOrder->setCommand($receive);
        return $command->run();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function deliver(array $payload): array
    {
        $deliver = new Deliver($this->orderRepo, $payload);
        $command = $this->invokeOrder->setCommand($deliver);
        return $command->run();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function reject(array $payload): array
    {
        $payload["status"] = Hooks::REJECTED;
        $payload["revoker_id"] = Revokers::COURIER;
        $reject = new Revoke($this->orderRepo, $payload);
        $command = $this->invokeOrder->setCommand($reject);
        return $command->run();
    }

    /**
     * @param array $payload
     * @return array
     */
    public function reclaim(array $payload): array
    {
        $payload["status"] = Hooks::RECLAIMED;
        $reclaim = new Reclaim($this->orderRepo, $payload);
        $command = $this->invokeOrder->setCommand($reclaim);
        return $command->run();
    }
}
