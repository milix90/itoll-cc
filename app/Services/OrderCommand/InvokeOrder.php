<?php

namespace App\Services\OrderCommand;

class InvokeOrder
{
    private OrderCommandAbstraction $command;

    public function setCommand(OrderCommandAbstraction $command): self
    {
        $this->command = $command;
        return $this;
    }

    public function run(): array
    {
        return $this->command->handle();
    }
}
