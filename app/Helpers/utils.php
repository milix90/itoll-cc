<?php

use App\Constants\Revokers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('success_api_response')) {
    /**
     *  success response.
     *
     * @param string $message
     * @param array $data
     * @param int $httpStatusCode
     * @param int $total
     * @param int $perPage
     * @param array|null $extra
     *
     * @return JsonResponse
     */
    function success_api_response(
        string $message,
        array $data,
        int $httpStatusCode,
        int $total,
        int $perPage,
        ?array $extra = []
    ): JsonResponse {
        return api_response($message, $data, $httpStatusCode, $total, $perPage, null, $extra);
    }
}

if (!function_exists('fail_api_response')) {
    /**
     *  fail response.
     *
     * @param string $message
     * @param string $error
     * @param array $data
     * @param int $httpStatusCode
     *
     * @return JsonResponse
     */
    function fail_api_response(
        string $message,
        string $error,
        array $data = [],
        int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        if ($httpStatusCode === Response::HTTP_UNPROCESSABLE_ENTITY && count($data)) {
            $data = process_validation($data);
        }

        return api_response($message, $data, $httpStatusCode, 0, 0, $error);
    }
}

if (!function_exists('api_response')) {
    /**
     * API response.
     *
     * @param string|null $message
     * @param array|null $entityData
     * @param int $httpStatusCode
     * @param int|null $total
     * @param int|null $perPage
     * @param string|null $error
     * @param array|null $extra
     *
     * @return JsonResponse
     */
    function api_response(
        ?string $message,
        ?array $entityData,
        int $httpStatusCode,
        ?int $total,
        ?int $perPage,
        ?string $error,
        ?array $extra = []
    ): JsonResponse {
        $data = !$extra ?
            [
                'total' => $total,
                'per_page' => $perPage,
                'result' => $entityData,
            ] :
            [
                'total' => $total,
                'per_page' => $perPage,
                'result' => $entityData,
                'extra' => $extra,
            ];
        if ($httpStatusCode === 503) {
            return response()->json([
                'message' => $message,
                'error' => $error,
                'represented_at' => date('Y-m-d H:i:s.u'),
                'data' => $data
            ], $httpStatusCode, ["Retry-After" => 11], JSON_UNESCAPED_UNICODE);
        }
        return response()->json([
            'message' => $message,
            'error' => $error,
            'represented_at' => date('Y-m-d H:i:s.u'),
            'data' => $data
        ], $httpStatusCode, [], JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('process_validation')) {
    /**
     * @param array $data
     * @return array
     */
    function process_validation(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            foreach ($value as $error) {
                $temp['field'] = $key;
                $temp['error'] = $error;
                $result[] = $temp;
            }
        }

        return $result;
    }
}

if (!function_exists('parse_token')) {
    /**
     * @param Request $request
     * @return Builder|bool
     */
    function parse_token(Request $request): array|bool
    {
        $decode = base64_decode($request->header("token"));
        $values = explode("_", $decode);

        if (!in_array($values[1], [Revokers::INVOKER, Revokers::COURIER])) {
            return false;
        }

        return [
            "identity_code" => $values[0],
            "client" => $values[1],
        ];
    }
}

if (!function_exists('log_custom_error')) {
    /**
     * @param \Exception $e
     * @return void
     */
    function log_custom_error(\Exception $e): void
    {
        Log::error(sprintf("%s\n%s", $e->getMessage(), $e->getTraceAsString()));
    }
}
