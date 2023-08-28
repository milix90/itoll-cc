<?php

namespace App\Repositories\Order;

use App\Entities\OrderEntity;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class OrderRepository extends BaseRepository implements OrderRepositoryAbstraction
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function retrieveOrderBulk(string $column, mixed $values, array $relations = []): array
    {
        try {
            $orders = $this->model->whereIn($column, $values)->with($relations)->get();
            $result = OrderResource::collection($orders)->toArray(request());
        } catch (\Exception $e) {
            log_custom_error($e);
            return ["status" => Response::HTTP_UNPROCESSABLE_ENTITY, "msg" => $e->getMessage()];
        }

        return ["status" => Response::HTTP_OK, "data" => $result];
    }

    public function retrieveOrder(string $column, mixed $value, array $relations = []): array
    {
        try {
            $order = $this->model->where($column, $value)->with($relations)->first();
            $result = (new OrderResource($order))->toArray(request());
        } catch (\Exception $e) {
            log_custom_error($e);
            return ["status" => Response::HTTP_UNPROCESSABLE_ENTITY, "msg" => $e->getMessage()];
        }

        return ["status" => Response::HTTP_OK, "data" => $result];
    }

    public function createOrder(array $payload): array
    {
        $orderEntity = (new OrderEntity)
            ->setInvokerId($payload["invoker_id"])
            ->setOrderCode(Str::uuid()->toString())
            ->setOrigin($payload["origin"])
            ->setOriginAddress($payload["origin_address"])
            ->setClientName($payload["client_name"])
            ->setClientMobile($payload["client_mobile"])
            ->setDestination($payload["destination"])
            ->setDestinationAddress($payload["destination_address"])
            ->setReceiverName($payload["receiver_name"])
            ->setReceiverMobile($payload["receiver_mobile"])
            ->setDeliverEstimate($payload["deliver_estimate"])
            ->toArray();

        try {
            $order = $this->model->create($orderEntity);
        } catch (\Exception $e) {
            log_custom_error($e);
            return ["status" => Response::HTTP_UNPROCESSABLE_ENTITY, "msg" => $e->getMessage()];
        }

        return [
            "status" => Response::HTTP_CREATED,
            "msg" => __("custom.success"),
            "order_code" => $order->order_code,
            "delivery_estimation" => $order->deliver_estimate,
        ];
    }

    public function updateOrder(array $payload, bool $lock = false): array
    {
        try {
            $order = $this->model->where("order_code", "=", $payload["order_uuid"]);

            // handle race condition
            if ($lock) {
                $order = $order->lockForUpdate();
            }

            $order = $order->first();

            //as the unset is compatible with all order commands, it used here
            if (isset($payload["order_uuid"], $payload["client"])) {
                unset($payload["order_uuid"], $payload["client"]);
            }

            $order->update($payload);
        } catch (\Exception $e) {
            log_custom_error($e);
            return ["status" => Response::HTTP_UNPROCESSABLE_ENTITY, "msg" => $e->getMessage()];
        }

        return ["status" => Response::HTTP_NO_CONTENT, "msg" => __("custom.success")];
    }
}
