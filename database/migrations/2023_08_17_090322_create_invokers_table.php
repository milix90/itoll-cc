<?php

use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private string $invoker_index = Tables::INVOKERS . '_username';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Tables::INVOKERS, function (Blueprint $table) {
            $table->id('invoker_id');
            $table->string('identity_code');
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->index('username', $this->invoker_index);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Tables::INVOKERS, function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
};
