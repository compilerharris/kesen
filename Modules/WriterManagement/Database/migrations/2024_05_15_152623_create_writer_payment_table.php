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
        Schema::create('writer_payments', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('sr_no')->autoIncrement();
            $table->string('writer_id');
            $table->string('payment_method');
            $table->string('metrix');
            $table->boolean('apply_gst')->default(false);
            $table->boolean('apply_tds')->default(false);
            $table->date('period_from');
            $table->date('period_to');
            $table->string('online_ref_no')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('performance_charge');
            $table->string('deductible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writer_payment');
    }
};
