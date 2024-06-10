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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('srno')->autoIncrement();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone_no')->nullable()->unique();
            $table->string('landline')->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('metrix')->nullable();
            $table->boolean('is_protocol');
            $table->string('protocol_data')->nullable();
            $table->string('accountant')->nullable();
            $table->string('estimate_company')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('client');
    }
};
