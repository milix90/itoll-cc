<?php

namespace App\Constants;

use App\Http\Controllers\OrderController;

abstract class Endpoints
{
    public const API_V1 = [
        "description" => "API V1 Snapshot",
        "endpoint" => "v1",
        "name" => "v1.",
    ];

    public const ORDER = [
        "description" => "order handler controller",
        "endpoint" => "order",
        "name" => "order.",
        "class" => OrderController::class,
    ];
}
