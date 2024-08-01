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
        Schema::create('ratecards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id');
            $table->string('type');
            $table->string('t_rate');
            $table->string('v1_rate');
            $table->string('v2_rate');
            $table->string('bt_rate');
            $table->string('btv_rate');
            $table->string('t_minimum_rate');
            $table->string('v1_minimum_rate');
            $table->string('v2_minimum_rate');
            $table->string('bt_minimum_rate');
            $table->string('btv_minimum_rate');
            $table->string('lang');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratecards');
    }
};
