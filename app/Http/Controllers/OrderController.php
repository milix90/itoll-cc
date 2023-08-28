<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailableOrdersRequst;
use App\Http\Requests\InquireOrderRequest;
use App\Http\Requests\OrderApproveRequest;
use App\Http\Requests\OrderDeliverRequest;
use App\Http\Requests\OrderReceiveRequest;
use App\Http\Requests\OrderReclaimRequest;
use App\Http\Requests\OrderRejectRequest;
use App\Http\Requests\OrderRevokeRequest;
use App\Http\Requests\OrderSubmitRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use function success_api_response;


class OrderController extends Controller
{
    public function __construct(public OrderService $order)
    {
    }

    public function available(AvailableOrdersRequst $request): JsonResponse
    {
        $result = $this->order->available($request->all());

        if ($result["status"] != Response::HTTP_OK) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response(
            __("custom.success"),
            $result['data'],
            $result["status"],
            count($result['data']),
            count($result['data'])
        );
    }

    public function inquire(InquireOrderRequest $request): JsonResponse
    {
        $result = $this->order->inquire($request->all());

        if ($result["status"] != Response::HTTP_OK) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response(__("custom.success"), $result['data'], $result["status"], 1, 1);
    }

    public function submit(OrderSubmitRequest $request): JsonResponse
    {
        $result = $this->order->submit($request->all());

        if ($result["status"] != Response::HTTP_CREATED) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        $data = [
            "order_code" => $result["order_code"],
            "delivery_estimation" => $result["delivery_estimation"],
        ];

        return success_api_response($result["msg"], $data, $result["status"], 1, 1);
    }

    public function approve(OrderApproveRequest $request): JsonResponse
    {
        $result = $this->order->approve($request->all());

        if ($result["status"] != Response::HTTP_NO_CONTENT) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response($result["msg"], [], $result["status"], 1, 1);
    }

    public function revoke(OrderRevokeRequest $request): JsonResponse
    {
        $result = $this->order->revoke($request->all());

        if ($result["status"] != Response::HTTP_NO_CONTENT) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response($result["msg"], [], $result["status"], 1, 1);
    }

    public function receive(OrderReceiveRequest $request): JsonResponse
    {
        $result = $this->order->receive($request->all());

        if ($result["status"] != Response::HTTP_NO_CONTENT) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response($result["msg"], [], $result["status"], 1, 1);
    }

    public function deliver(OrderDeliverRequest $request): JsonResponse
    {
        $result = $this->order->deliver($request->all());

        if ($result["status"] != Response::HTTP_NO_CONTENT) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response($result["msg"], [], $result["status"], 1, 1);
    }

    public function reject(OrderRejectRequest $request): JsonResponse
    {
        $result = $this->order->reject($request->all());

        if ($result["status"] != Response::HTTP_NO_CONTENT) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response($result["msg"], [], $result["status"], 1, 1);
    }

    public function reclaim(OrderReclaimRequest $request): JsonResponse
    {
        $result = $this->order->reclaim($request->all());
        if ($result["status"] != Response::HTTP_NO_CONTENT) {
            return fail_api_response($result["msg"], "", [], $result["status"]);
        }

        return success_api_response($result["msg"], [], $result["status"], 1, 1);
    }
}
