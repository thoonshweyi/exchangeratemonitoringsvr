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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id');
            $table->string('branch_code');
            $table->string('branch_name');
            $table->string('branch_short_name')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_phone_no')->nullable();
            $table->boolean('branch_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
