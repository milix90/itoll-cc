<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderEntity
{
    private int $order_id = 0;
    private int $invoker_id = 0;
    private int $courier_id = 0;
    private string $order_code = "";
    private string $origin = "";
    private string $origin_address = "";
    private string $client_name = "";
    private string $client_mobile = "";
    private string $destination = "";
    private string $destination_address = "";
    private string $receiver_name = "";
    private string $receiver_mobile = "";
    private int $deliver_estimate = 0;
    private string $status = "";

    public function instance(Model $order): self
    {
        $this->invoker_id = $order->invoker_id ?? 0;
        $this->courier_id = $order->courier_id ?? 0;
        $this->order_code = $order->order_code ?? 0;
        $this->origin = $order->origin ?? "";
        $this->origin_address = $order->origin_address ?? "";
        $this->client_name = $order->client_name ?? "";
        $this->client_mobile = $order->client_mobile ?? "";
        $this->destination = $order->destination ?? "";
        $this->destination_address = $order->destination_address ?? "";
        $this->receiver_name = $order->receiver_name ?? "";
        $this->receiver_mobile = $order->receiver_mobile ?? "";
        $this->deliver_estimate = $order->deliver_estimate ?? 0;
        $this->status = $order->status ?? "";
        return $this;
    }

    public function fromArray(array $data): void
    {
        $this->order_id = $data['order_id'];
        $this->invoker_id = $data['invoker_id'];
        $this->courier_id = $data['courier_id'];
        $this->order_code = $data['order_code'];
        $this->origin = $data['origin'];
        $this->origin_address = $data['origin_address'];
        $this->client_name = $data['client_name'];
        $this->client_mobile = $data['client_mobile'];
        $this->destination = $data['destination'];
        $this->destination_address = $data['destination_address'];
        $this->receiver_name = $data['receiver_name'];
        $this->receiver_mobile = $data['receiver_mobile'];
        $this->deliver_estimate = $data['deliver_estimate'];
        $this->status = $data['status'];
    }

    public function toArray(): array
    {
        return [
            "invoker_id" => $this->invoker_id,
            "courier_id" => $this->courier_id ?: null,
            "order_code" => $this->order_code,
            "origin" => $this->origin,
            "origin_address" => $this->origin_address,
            "client_name" => $this->client_name,
            "client_mobile" => $this->client_mobile,
            "destination" => $this->destination,
            "destination_address" => $this->destination_address,
            "receiver_name" => $this->receiver_name,
            "receiver_mobile" => $this->receiver_mobile,
            "deliver_estimate" => $this->deliver_estimate,
            "status" => $this->status,
        ];
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     * @return OrderEntity
     */
    public function setOrderId(int $order_id): self
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getInvokerId(): int
    {
        return $this->invoker_id;
    }

    /**
     * @param int $invoker_id
     * @return OrderEntity
     */
    public function setInvokerId(int $invoker_id): self
    {
        $this->invoker_id = $invoker_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCourierId(): int
    {
        return $this->courier_id;
    }

    /**
     * @param int $courier_id
     * @return OrderEntity
     */
    public function setCourierId(int $courier_id): self
    {
        $this->courier_id = $courier_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderCode(): string
    {
        return $this->order_code;
    }

    /**
     * @param string $order_code
     * @return OrderEntity
     */
    public function setOrderCode(string $order_code): self
    {
        $this->order_code = $order_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     * @return OrderEntity
     */
    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginAddress(): string
    {
        return $this->origin_address;
    }

    /**
     * @param string $origin_address
     * @return OrderEntity
     */
    public function setOriginAddress(string $origin_address): self
    {
        $this->origin_address = $origin_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientName(): string
    {
        return $this->client_name;
    }

    /**
     * @param string $client_name
     * @return OrderEntity
     */
    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientMobile(): string
    {
        return $this->client_mobile;
    }

    /**
     * @param string $client_mobile
     * @return OrderEntity
     */
    public function setClientMobile(string $client_mobile): self
    {
        $this->client_mobile = $client_mobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     * @return OrderEntity
     */
    public function setDestination(string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationAddress(): string
    {
        return $this->destination_address;
    }

    /**
     * @param string $destination_address
     * @return OrderEntity
     */
    public function setDestinationAddress(string $destination_address): self
    {
        $this->destination_address = $destination_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverName(): string
    {
        return $this->receiver_name;
    }

    /**
     * @param string $receiver_name
     * @return OrderEntity
     */
    public function setReceiverName(string $receiver_name): self
    {
        $this->receiver_name = $receiver_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverMobile(): string
    {
        return $this->receiver_mobile;
    }

    /**
     * @param string $receiver_mobile
     * @return OrderEntity
     */
    public function setReceiverMobile(string $receiver_mobile): self
    {
        $this->receiver_mobile = $receiver_mobile;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeliverEstimate(): int
    {
        return $this->deliver_estimate;
    }

    /**
     * @param int $deliver_estimate
     * @return OrderEntity
     */
    public function setDeliverEstimate(int $deliver_estimate): self
    {
        $this->deliver_estimate = $deliver_estimate;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return OrderEntity
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
