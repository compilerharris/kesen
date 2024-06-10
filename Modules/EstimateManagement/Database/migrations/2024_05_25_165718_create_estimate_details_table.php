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
        Schema::create('estimate_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('sr_no')->autoIncrement();
            $table->foreignUuid('estimate_id');
            $table->string('document_name');
            $table->string('type');
            $table->string('unit');
            $table->decimal('rate', 10, 2);
            $table->string('verification');
            $table->string('verification_2');
            $table->string('back_translation');
            $table->string('layout_charges');
            $table->string('layout_charges_2');
            $table->string('lang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_details');
    }
};
