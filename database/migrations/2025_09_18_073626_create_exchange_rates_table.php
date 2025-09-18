<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("currency_id");
            $table->decimal("tt_buy",12,4)->default(0);
            $table->decimal("tt_sell",12,4)->default(0);
            $table->decimal("cash_buy",12,4)->default(0);
            $table->decimal("cash_sell",12,4)->default(0);
            $table->decimal("earn_buy",12,4)->default(0);
            $table->decimal("earn_sell",12,4)->default(0);
            $table->timestamp("record_at");
            $table->text("description")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
