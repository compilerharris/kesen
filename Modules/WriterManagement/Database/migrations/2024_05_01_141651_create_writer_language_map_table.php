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
        Schema::create('writer_language_maps', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('writer_id');
            $table->integer('per_unit_charges')->length(4);
            $table->integer('checking_charges');
            $table->integer('bt_charges');
            $table->integer('bt_checking_charges');
            $table->integer('advertising_charges');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writer_language_map');
    }
};
