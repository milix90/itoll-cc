<?php

namespace App\Constants;

abstract class Hooks
{
    public const WAITING = "waiting";
    public const ACCEPTED = "accept";
    public const LEAVING = "leaving";
    public const REVOKED = "revoked";
    public const RECEIVED = "received";
    public const DELIVERING = "delivering";
    public const DELIVERED = "delivered";
    public const REJECTED = "rejected";
    public const RECLAIMING = "reclaiming";
    public const RECLAIMED = "reclaimed";
}
