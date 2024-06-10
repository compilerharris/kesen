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
        Schema::create('estimates', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('sr_no')->autoIncrement();
            $table->string('estimate_no')->unique();
            $table->string('metrix')->nullable();
            $table->string('client_id');
            $table->string('client_contact_person_id')->nullable();
            $table->string('headline')->nullable();
            $table->string('amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->default(0);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
