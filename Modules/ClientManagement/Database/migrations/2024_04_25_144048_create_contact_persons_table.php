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
        Schema::create('contact_persons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id');
            $table->string('name');
            $table->string('phone_no')->unique()->nullable();
            $table->string('landline')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('designation')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_persons');
    }
};
