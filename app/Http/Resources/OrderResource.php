<?php

namespace App\Http\Resources;

use App\Entities\OrderEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orderEntity = new OrderEntity();
        $orderEntity->instance($this->resource);

        return [
            "order_code" => $orderEntity->getOrderCode(),
            "origin" => $orderEntity->getOrigin(),
            "origin_address" => $orderEntity->getOriginAddress(),
            "destination" => $orderEntity->getDestination(),
            "destination_address" => $orderEntity->getOriginAddress(),
            "delivery_estimation" => $orderEntity->getDeliverEstimate(),
            "status" => $orderEntity->getStatus(),
        ];
    }
}
