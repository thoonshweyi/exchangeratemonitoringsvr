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
        Schema::create('change_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("currency_id");
            $table->string("type");
            $table->decimal("buy",12,4)->default(0);
            $table->decimal("sell",12,4)->default(0);
            $table->timestamp("record_at");
            $table->string("description")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("exchange_docu_id");
            $table->unsignedBigInteger("refexchange_rate_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_histories');
    }
};
