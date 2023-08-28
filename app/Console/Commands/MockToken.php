<?php

namespace App\Console\Commands;

use App\Constants\Revokers;
use App\Models\Courier;
use App\Models\Invoker;
use App\Repositories\Courier\CourierRepository;
use App\Repositories\Invoker\InvokerRepository;
use Illuminate\Console\Command;

class MockToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:mock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mock auth token for invoker and courier';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$invokerRepo, $courierRepo] = [new InvokerRepository(new Invoker), new CourierRepository(new Courier)];

        $invoker = $invokerRepo->model->latest()->first();
        $invokerToken = base64_encode(sprintf("%s_%s", $invoker->identity_code, Revokers::INVOKER));

        $courier = $courierRepo->model->latest()->first();
        $courierToken = base64_encode(sprintf("%s_%s", $courier->identity_code, Revokers::COURIER));

        $this->info("invoker token: \n{$invokerToken}\n");
        $this->info("courier token: \n{$courierToken}\n");
    }
}
