<?php

use App\Constants\Hooks;
use App\Constants\Revokers;
use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private string $order_invoker_index = Tables::ORDERS . '_invoker_id';
    private string $order_code_index = Tables::ORDERS . '_order_code';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Tables::ORDERS, function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('invoker_id');
            $table->foreign('invoker_id')->references('invoker_id')->on('invokers');
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->foreign('courier_id')->references('courier_id')->on('couriers');
            $table->string('origin');
            $table->string('origin_address');
            $table->string('client_name');
            $table->string('client_mobile');
            $table->string('destination');
            $table->string('destination_address');
            $table->string('receiver_name');
            $table->string('receiver_mobile');
            $table->integer('deliver_estimate')->comment("delivery time estimation by minutes");
            $table->enum('status', [
                Hooks::WAITING,
                Hooks::ACCEPTED,
                Hooks::LEAVING,
                Hooks::REVOKED,
                Hooks::RECEIVED,
                Hooks::DELIVERING,
                Hooks::DELIVERED,
                Hooks::REJECTED,
                Hooks::RECLAIMING,
                Hooks::RECLAIMED,
            ])->default(Hooks::WAITING);
            $table->enum('revoker_id', [
                Revokers::INVOKER,
                Revokers::COURIER,
            ])->nullable();
            $table->text('revoke_desc')->nullable();
            $table->timestamps();

            $table->index('invoker_id', $this->order_invoker_index);
            $table->index('order_code', $this->order_code_index);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Tables::ORDERS, function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
};
