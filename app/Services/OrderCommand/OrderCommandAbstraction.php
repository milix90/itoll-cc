<?php

namespace App\Services\OrderCommand;

interface OrderCommandAbstraction
{
    public function handle(): array;
}
