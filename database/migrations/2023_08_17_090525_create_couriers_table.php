<?php

use App\Constants\Tables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private string $courier_index = Tables::COURIERS . '_username';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Tables::COURIERS, function (Blueprint $table) {
            $table->id('courier_id');
            $table->string('identity_code');
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->index('username', $this->courier_index);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Tables::COURIERS, function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
};
