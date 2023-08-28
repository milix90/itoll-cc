<?php

namespace App\Http\Middleware\custom;

use App\Constants\Revokers;
use App\Models\Courier;
use App\Models\Invoker;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EvaluateClient
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $result = parse_token($request);

        if (!$result) {
            //invalid token
            return fail_api_response(
                __(""), // todo: handle message translation
                null,
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        // todo: handle allocated routes for specific client

        $client = $this->detectClient($result);

        if (!$client->exists()) {
            return fail_api_response(
                __(""), // todo: handle message translation
                null,
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        if (!$client->first()->active) {
            return fail_api_response(
                __(""),
                null,
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        return $next($request);
    }

    // HELPER METHODS

    /**
     * @param Builder|bool|array $result
     * @return Builder
     */
    private function detectClient(Builder|bool|array $result): Builder
    {
        if ($result["client"] == Revokers::INVOKER) {
            $model = (new Invoker())->query();
        } else {
            $model = (new Courier())->query();
        }

        return $model->where("identity_code", "=", $result["identity_code"]);
    }
}


