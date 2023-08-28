<?php

namespace App\Repositories\Invoker;

interface InvokerRepositoryAbstraction
{
    public function retrieveInvoker(string $identity): array;
}
