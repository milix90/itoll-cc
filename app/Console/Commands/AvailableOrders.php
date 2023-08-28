<?php

namespace App\Console\Commands;

use App\Constants\Hooks;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class AvailableOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:available';

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
        $orders = (new OrderRepository(new Order))->model->latest()->lazy();
        $availableOrders = Redis::command("keys", ["*"]);

        if (count($availableOrders) > 0) {
            $deprecated = $orders->whereIn("order_code", $availableOrders)
                ->where("status", "<>", Hooks::WAITING);

            Redis::pipeline(function ($pipe) use ($deprecated) {
                foreach ($deprecated as $order) {
                    $pipe->del($order->order_code);
                }
            });
        }

        $waitingOrders = $orders->where("status", "=", Hooks::WAITING);

        Redis::pipeline(function ($pipe) use ($waitingOrders) {
            foreach ($waitingOrders as $order) {
                $pipe->setnx($order->order_code, $order->status);
            }
        });
    }
}
