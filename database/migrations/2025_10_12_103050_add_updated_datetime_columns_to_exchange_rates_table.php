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
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->timestamp('tt_updated_datetime')->nullable();
            $table->timestamp('cash_updated_datetime')->nullable();
            $table->timestamp('earn_updated_datetime')->nullable();
        });

        DB::table('exchange_rates')->update([
            'tt_updated_datetime' => DB::raw('record_at'),
            'cash_updated_datetime' => DB::raw('record_at'),
            'earn_updated_datetime' => DB::raw('record_at'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn("tt_updated_datetime");
            $table->dropColumn("cash_updated_datetime");
            $table->dropColumn("earn_updated_datetime");
        });
    }
};
