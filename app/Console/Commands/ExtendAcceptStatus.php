<?php

namespace App\Console\Commands;

use App\Constants\Hooks;
use App\Events\OrderStatusHandlerEvent;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Console\Command;

class ExtendAcceptStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:extend:accept';
    protected $hidden = true;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $orders = (new OrderRepository(new Order))->model->latest()
                ->where("status", "=", Hooks::ACCEPTED);

            $orders->update(["status" => Hooks::LEAVING]);

            $emails = $orders->with("invoker:invoker_id,email")
                ->get()
                ->pluck("invoker.email")
                ->toArray();

            OrderStatusHandlerEvent::dispatch($emails);
        } catch (\Exception $e) {
            log_custom_error($e);
        }
    }
}
